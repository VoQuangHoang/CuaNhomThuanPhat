<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blogs;
use App\Models\Posts;
use App\Models\Categories;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Tags\TagsRepository;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Repositories\BlogTag\BlogTagRepository;
use App\Repositories\Categories\CategoriesRepository;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BlogsController extends Controller
{
    protected $blogs, $categories, $tags, $blog_tag;

    public function __construct(BlogRepository $blogs, CategoriesRepository $categories, TagsRepository $tags, BlogTagRepository $blog_tag)
    {
        $this->blogs = $blogs;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->blog_tag = $blog_tag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(auth()->user()->can('blog list')){
            $data = $this->blogs->latest()->get();
         
            return view("admin.blog.list", compact('data'));
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
        if(auth()->user()->can('blog add')){
            $categories = $this->categories->where('type', 'blog_category')->get();
            return view('admin.blog.create', compact('categories'));
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        if(auth()->user()->can('blog add')){
            $input = $request->all();

            $tagsAll = $this->tags->getTagsByType(2)->pluck('name')->toArray();

            $input['slug'] =  SlugService::createSlug(Blogs::class, 'slug', $request->title);

            $input['status'] = $request->status == 1 ? 1 : null;

            $input['created_by'] =  \Auth::user()->id;

            $input['updated_by'] =  \Auth::user()->id;

            $blog = $this->blogs->create($input);

            if($request->tags){
                $tags = $input['tags'];

                $addTagsAll = array_diff($tags, $tagsAll);

                foreach ($addTagsAll as $item){
                    $this->tags->create(['name' => $item, 'slug' => Str::slug($item), 'type' => 2, 'description' => $item]);
                }

                foreach ($tags as $item){
                    $idTag = $this->tags->where('name', $item)->where('type', 2)->first();
                    $this->blog_tag->create(['blog_id' => $blog->id, 'tag_id' => $idTag->id]);
                }
            }

            return redirect()->route('blogs.index')->with('success', 'Thêm mới thành công');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->can('blog edit')){
            $categories = $this->categories->where('type', 'blog_category')->get();

            $data = $this->blogs->findOrFail($id);
            
            return view('admin.blog.edit', compact('categories','data'));
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
    public function update(StoreBlogRequest $request, $id)
    {
        if(auth()->user()->can('blog edit')){
        $blog = $this->blogs->findOrFail($id);

        

        $input = $request->all();

        if($blog->title != $request->title)
        {
            $slug = SlugService::createSlug(Blogs::class, 'slug', $request->title);
            $input['slug'] = $slug; 
        }

        

        $input['status'] = $request->status == 1 ? 1 : null;

        $input['updated_by'] =  \Auth::user()->id;

        $blog->update($input);

        

            $tagsAll = $this->tags->getTagsByType(2)->pluck('name')->toArray();
        
            $tags = $request->tags ? $request->tags : [];

            $addTagsAll = array_diff($tags, $tagsAll);

            foreach ($addTagsAll as $item){
                $this->tags->create(['name' => $item, 'slug' => Str::slug($item), 'type' => 2, 'description' => $item]);
            }

            $oldBlogTags = $blog->Tags->keyBy('id');
            $formattedTags = [];

            foreach ($oldBlogTags as $key => $tag) {
                $formattedTags[$key] = $tag->name;
            }
            
            $newBlogTags = !empty($tags) ? $tags : [];
            
            $delBlogTags = array_diff($formattedTags, $newBlogTags);
            if(!empty($delBlogTags)){
                foreach ($delBlogTags as $item){
                    $tagId = array_search($item, $formattedTags);
                    $idTag = $this->blog_tag->where('tag_id', $tagId)->where('blog_id', $blog->id)->first()->id;
                    $this->blog_tag->destroy($idTag);
                }
            };
            
            $addBlogTags = array_diff($newBlogTags, $formattedTags);
            if(!empty($addBlogTags)){
                foreach ($addBlogTags as $item){
                    $idTag = $this->tags->where('name', $item)->first();
                    $this->blog_tag->create(['blog_id' => $blog->id, 'tag_id' => $idTag->id]);
                }
            }
        
        
        return back()->with('success', 'Cập nhật thành công');
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
        if(auth()->user()->can('blog delete')){
            Blogs::destroy($id);
            
            return redirect()->back()->with('success', 'Xóa thành công');
        }
        abort(406);
    }

    public function getTags(Request $request)
    {
        $input = $request->q;
        if (empty($input)) {
            return response()->json([]);
        }

        $tags = $this->tags->where('name', 'like', $input.'%')->where('type', 2)->get();

        $formattedTags = [];

        foreach ($tags as $tag) {
            $formattedTags[] = ['id' => $tag->name, 'text' => $tag->name];
        }

        return response()->json($formattedTags);
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('blog delete')){
            if(!empty($request->chkItem)){

                foreach ($request->chkItem as $id) {
                    Blogs::destroy($id);
                }

                return back()->with('success', 'Xóa thành công');
            }
            
            return back()->with('error', 'Bạn chưa chọn dữ liệu cần xóa.');
        }
        abort(406);
    }
}
