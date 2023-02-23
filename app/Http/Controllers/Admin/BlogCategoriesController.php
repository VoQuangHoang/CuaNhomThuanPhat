<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Categories\CategoriesRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BlogCategoriesController extends Controller
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
        if(auth()->user()->can('blog category list')){
        $data = $this->categories->getCateByType('blog_category');
        return view('admin.blog-categories.list', compact('data'));
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
        if(auth()->user()->can('blog category add')){
            return view('admin.blog-categories.create');
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('blog category add')){
            $input = $request->all();

            $input['slug'] = SlugService::createSlug($this->categories->model(), 'slug', $request->name);

            $input['parent_id'] = 0;

            $input['type'] = 'blog_category';

            $this->categories->create($input);

            return redirect()->route('blog-categories.index')->with('success', 'Thêm mới thành công');
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
        if(auth()->user()->can('blog category edit')){
            $data = $this->categories->findOrFail($id);
            return view('admin.blog-categories.edit', compact('data'));
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
    public function update(Request $request, $id)
    {
        if(auth()->user()->can('blog category edit')){
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
        if(auth()->user()->can('blog category delete')){
            $this->categories->destroy($id);
            return redirect()->back()->with('success', 'Xóa thành công');
        }
        abort(406);
    }
}
