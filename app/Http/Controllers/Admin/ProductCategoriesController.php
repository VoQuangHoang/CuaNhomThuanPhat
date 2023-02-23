<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductCateRequest;
use App\Repositories\Categories\CategoriesRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductCategoriesController extends Controller
{
    private $categories;
    
    public function __construct(CategoriesRepository $categories)
    {
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('product category list')){
            $categories = $this->categories->getCateByType('product_category');
            return view('admin.product-categories.list', compact('categories'));
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
        if(auth()->user()->can('product category add')){
            $categories = $this->categories->getCateByType('product_category');
            return view('admin.product-categories.create', compact('categories'));
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCateRequest $request)
    {
        if(auth()->user()->can('product category add')){
            $data = $request->all();

            $data['type'] = 'product_category';

            $data['slug'] = SlugService::createSlug($this->categories->model(), 'slug', $request->name);

            $data['popular'] = $request->popular == 1 ? 1 : 0;

            $data['active'] = $request->active == 1 ? 1 : 0;

            $this->categories->create($data);

            return redirect()->route('product-categories.index')->with('success', 'Thêm mới thành công');
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
        if(auth()->user()->can('product category edit')){
        $categories = $this->categories->getCateByType('product_category');

        $data = $this->categories->findOrFail($id);

        return view('admin.product-categories.edit', compact('categories','data'));
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
    public function update(StoreProductCateRequest $request, $id)
    {
        if(auth()->user()->can('product category edit')){
        $input = $request->all();
            
        $cate = $this->categories->findOrFail($id);

        if ($input['name'] != $cate->name){
            $input['slug'] = SlugService::createSlug($this->categories->model(), 'slug', $request->name);
        }

        $input['popular'] = $request->popular == 1 ? 1 : 0;

        $input['active'] = $request->active == 1 ? 1 : 0;

        $cate->update($input);

        return redirect()->route('product-categories.index')->with('success', 'Cập nhật thành công');
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
        if(auth()->user()->can('product category delete')){
        $data = $this->categories->find($id);
        $this->categories->destroy($id);
        deleteCateChild($data);

        return back()->with('success', 'Xóa thành công');
    }
    abort(406);
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('product category delete')){
            if(!empty($request->chkItem)){
                foreach ($request->chkItem as $id) {
                    $data = $this->categories->findByField('id',$id);
                    if(!empty($data)){
                        deleteCateChild($data);
                        $this->categories->destroy($id);
                    } 
                }
                return back()->with('success', 'Xóa thành công');
            }
            return back()->with('error', 'Bạn chưa chọn dữ liệu cần xóa.');
        }
        abort(406);
    }
}
