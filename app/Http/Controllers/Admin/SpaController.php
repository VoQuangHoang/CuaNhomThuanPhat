<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spa;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Spa\SpaRepository;
use App\Http\Requests\Admin\StoreSpaRequest;
use App\Repositories\Categories\CategoriesRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SpaController extends Controller
{
    protected $spa, $categories;

    public function __construct(SpaRepository $spa, CategoriesRepository $categories)
    {
        $this->spa = $spa;
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->spa->latest()->get();
         
            return view("admin.spa.list", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories->getCateByType('spa_category');
        return view('admin.spa.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpaRequest $request)
    {
        $input = $request->all();

        $input['slug'] =  SlugService::createSlug(Spa::class, 'slug', $request->title);

        $input['status'] = $request->status == 1 ? 1 : null;

        $input['created_by'] =  \Auth::user()->id;

        $input['updated_by'] =  \Auth::user()->id;

        $blog = $this->spa->create($input);

        return redirect()->route('spa.index')->with('success', 'Thêm mới thành công');
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
        $categories = $this->categories->getCateByType('spa_category');

        $data = $this->spa->findOrFail($id);
        
        return view('admin.spa.edit', compact('categories','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSpaRequest $request, $id)
    {
        $blog = $this->spa->findOrFail($id);

        $input = $request->all();

        if($blog->name != $request->title)
        {
            $slug = SlugService::createSlug(Categories::class, 'slug', $request->title);
            $input['slug'] = $slug; 
        }

        $input['status'] = $request->status == 1 ? 1 : null;

        $input['updated_by'] =  \Auth::user()->id;

        $blog->update($input);

        return back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->spa->destroy($id);
            
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function postMultiDel(Request $request)
    {
       
            if(!empty($request->chkItem)){

                foreach ($request->chkItem as $id) {
                    $this->spa->destroy($id);
                }

                return back()->with('success', 'Xóa thành công');
            }
            return back()->with('error', 'Bạn chưa chọn dữ liệu cần xóa.');

       
    }
}
