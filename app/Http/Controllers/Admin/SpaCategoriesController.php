<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductCateRequest;
use App\Repositories\Categories\CategoriesRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SpaCategoriesController extends Controller
{
    protected $categories;

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
        $data = $this->categories->getCateByType('spa_category');
        return view('admin.spa-categories.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.spa-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCateRequest $request)
    {
        $input = $request->all();

        $input['slug'] = SlugService::createSlug($this->categories->model(), 'slug', $request->name);

        $input['parent_id'] = 0;

        $input['type'] = 'spa_category';

        $this->categories->create($input);

		return redirect()->route('spa-categories.index')->with('success', 'Thêm mới thành công');
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
        $data = $this->categories->findOrFail($id);
        return view('admin.spa-categories.edit', compact('data'));
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
        $data = $this->categories->findOrFail($id);

        $input = $request->all();
        
        $name = $data->name;
        if($name != $request->name)
        {
            $slug = SlugService::createSlug($this->categories->model(), 'slug', $request->name);
            $input['slug'] = $slug; 
        }

        $data->update($input);

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categories->destroy($id);
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
