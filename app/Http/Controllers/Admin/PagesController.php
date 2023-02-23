<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Pages\PagesRepository;

class PagesController extends Controller
{
    protected $pages;

    public function __construct(PagesRepository $pages)
    {
        $this->pages = $pages;
    }

    public function getListPages()
	{
		if(auth()->user()->can('page list')){
			$data = $this->pages->orderBy('id', 'ASC')->get();

			return view('admin.pages.list', compact('data'));
		}
		abort(406);
		
	}

	public function postCreatePages(Request $request)
	{
		$data = [
			'name_page' => $request->name_page,
			'type' => $request->type,
			'route' => $request->route,
		];

		$this->pages->create($data);

		return redirect()->back()->with('success', 'Thêm mới thành công');
	}

    public function getBuildPages(Request $request)
    {
		if(auth()->user()->can('page build')){
		$type = $request->page;

		$data = $this->pages->where('type', $type)->first();
		
		if(view()->exists('admin.pages.layouts.'.$type)){
			return view('admin.pages.layouts.'.$type, compact('data'));
		}

		return view('admin.pages.layouts.default', compact('data'));
		}
		abort(406);
    }

    public function postBuildPages(Request $request)
    {
       	$type = $request->type;

    	$data = $this->pages->where('type', $type)->first();

		$data->content = !empty($request->content) ? json_encode($request->content) : NULL;

    	$data->meta_title = $request->meta_title;

    	$data->meta_description = $request->meta_description;

    	$data->meta_keyword = $request->meta_keyword;

    	$data->image = $request->image;

		$data->banner = $request->banner;

    	$data->save();

    	return redirect()->back()->with('success', 'Cập nhật thành công');
    	
    }
}
