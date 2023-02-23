<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Tags\TagsRepository;
use App\Http\Requests\Admin\EditProductRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Attributes\AttributesRepository;
use App\Repositories\Brands\BrandsRepositoryEloquent;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\ProductTag\ProductTagRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;

class ProductsController extends Controller
{
    protected $products, $categories, $brands, $product_category, $attributes, $tags, $product_tag;

    public function __construct(CategoriesRepository $categories, ProductsRepository $products, BrandsRepositoryEloquent $brands,
        ProductCategoryRepository $product_category, TagsRepository $tags, ProductTagRepository $product_tag,AttributesRepository $attributes)
    {
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->product_category = $product_category;
        $this->tags = $tags;
        $this->attributes = $attributes;
        $this->product_tag = $product_tag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->can('product list')){
        $products = $this->products->getSearchProduct($request);
        $categories = $this->categories->getCateByType('product_category');
        $users = \App\Models\User::all();
        return view("admin.products.list", compact('products', 'categories', 'users'));
        }
        abort(406);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('product add')){
        $categories = $this->categories->getCateByType('product_category');

        $list_brand = $this->brands->orderBy('name', 'ASC')->get();

        return view('admin.products.create', compact('categories','list_brand'));
    }
    abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if(auth()->user()->can('product add')){
        $this->products->addProduct($request);
        return redirect()->route('products.index')->with('success', 'Thêm mới thành công');
    }
    abort(406);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('product edit')){
        $data = $this->products->findOrFail($id);

        $categories = $this->categories->getCateByType('product_category');

        $list_brand = $this->brands->orderBy('name', 'ASC')->get();

        $array_id = $this->product_category->getArrayProCate($id);
        
        return view('admin.products.edit', compact('categories','data','array_id', 'list_brand'));
    }
    abort(406);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        if(auth()->user()->can('product edit')){
        $this->products->updateProduct($request, $id);
        return redirect()->back()->with('success','Cập nhật thành công');
    }
    abort(406);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('product delete')){
        $this->products->destroy($id);
        
        return redirect()->back()->with('success','Xóa thành công');
    }
    abort(406);
    }

    public function getTags(Request $request)
    {
        $input = $request->q;
        if (empty($input)) {
            return response()->json([]);
        }

        $tags = $this->tags->where('name', 'like', $input.'%')->where('type', 1)->get();

        $formattedTags = [];

        foreach ($tags as $tag) {
            $formattedTags[] = ['id' => $tag->name, 'text' => $tag->name];
        }

        return response()->json($formattedTags);
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('product delete')){
            if(!empty($request->chkItem)){

                foreach ($request->chkItem as $id) {
                    $this->products->destroy($id);
                }

                return back()->with('success','Xóa thành công');
            }
            return back()->with('error','Bạn chưa chọn dữ liệu cần xóa');
        }
        abort(406);
      
    }

    public function moveToTrash($id){
        if(auth()->user()->can('product delete')){
            $this->products->find($id)->update(['status' => 3]);
            return back()->with('success','Đã di chuyển sản phẩm vào Thùng rác');
        }
        abort(406);
        
    }

    public function getTrash()
    {
        if(auth()->user()->can('product delete')){
            $products = $this->products->findByField('status', 3);
            return view('admin.products.trash', compact('products'));
        }
        abort(406);
    }

    public function postMultiMoveTrash(Request $request)
    {
        if(auth()->user()->can('product delete')){
            if(!empty($request->chkItem)){

                foreach ($request->chkItem as $id) {
                    $this->products->find($id)->update(['status' => 3]);
                }
                return back()->with('success','Đã di chuyển các sản phẩm vào Thùng rác');
            }
            return back()->with('error','Bạn chưa chọn dữ liệu cần xóa');
        }
        abort(406);
    }
}
