<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Tags\TagsRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Categories\CategoriesRepository;

class PageBlogsController extends Controller
{
    protected $blogs,$pages,$categories, $tags;

    public function __construct(BlogRepository $blogs,PagesRepository $pages, CategoriesRepository $categories, TagsRepository $tags)
    {
        $this->blogs = $blogs;
        $this->pages = $pages;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->pages->seoGeneral();
    }
    public function getBlog()
    {
        $dataSeo = $this->pages->getDataByType('blogs');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        $newBlogs = $this->blogs->getNewBlogs(6);
        $mostViewBlogs = $this->blogs->getMostViewBlogs(5);
        $cateBlogs = $this->categories->getCateByType('blog_category');
        $blogTags = $this->tags->getTagsByType(2);
        return view('frontend.pages.blogs', compact('newBlogs', 'dataSeo', 'contentPage','cateBlogs','mostViewBlogs','blogTags'));
    }

    public function getBlogCate($slug)
    {
        // $dataSeo = $this->pages->getDataByType('blogs');
        $mostViewBlogs = $this->blogs->getMostViewBlogs(5);
        $cateBlogs = $this->categories->getCateByType('blog_category');
        $cate = $this->categories->getCateBySlug($slug, 'blog_category');
        $cateBySlug = $cate->Blogs()->where('status', 1)->paginate(9);
        $blogTags = $this->tags->getTagsByType(2);
        $this->pages->createSeoCategory($cate, $cateBySlug, $type='blog_category');
        return view('frontend.pages.blog_cate', compact('mostViewBlogs', 'cateBlogs', 'cateBySlug', 'blogTags','cate'));
    }

    public function getBlogTags($slug)
    {
        $dataSeo = $this->pages->getDataByType('blogs');
        $this->pages->createSeo($dataSeo);
        $mostViewBlogs = $this->blogs->getMostViewBlogs(5);
        $blogTags = $this->tags->getTagsByType(2);
        $cateBlogs = $this->categories->getCateByType('blog_category');
        $tag = $this->tags->getTagsBySlug($slug, 2);
        $blogByTag = $tag->BlogTag()->paginate(9);
        return view('frontend.pages.blog_tag', compact('mostViewBlogs', 'cateBlogs', 'blogByTag', 'blogTags','tag'));
    }

    public function getBlogSingle($slug)
    {
        $blog = $this->blogs->where('slug', $slug)->first();
        $blog->increment('view');
        $this->pages->createSeoBlog($blog);
        return view('frontend.pages.blog_single', compact('blog'));
    }
}
