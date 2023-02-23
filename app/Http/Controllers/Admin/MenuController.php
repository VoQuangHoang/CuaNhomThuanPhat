<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\MenuGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function getGroupMenu()
    { 
        $menu = MenuGroup::all();
        return view('admin.menu.list', compact('menu'));
    }

    public function postAddMenu(Request $request, $id)
    {
        $lastMenu = Menu::where('group_id', $id)->orderBy('position', 'desc')->first();

        $menu = Menu::where('group_id', $id)->pluck('url')->toArray();

        if(in_array($request->url, $menu)){
            return back();
        }

        $data = [
            'title' => $request->title,
            'url' => $request->url,
            'position' => !empty($lastMenu->position) ? $lastMenu->position + 1 : 0,
            'group_id' => $id,
            'parent_id' => 0,
            'class' => $request->class
        ];

        Menu::create($data);
        return back();

    }

    public function getEditMenu($id)
    {
        
            $data = Menu::where('group_id', $id)->orderBy('position')->get();

            $menuGroup = MenuGroup::find($id)->first();

            return view('admin.menu.menu-edit', compact('id', 'data', 'menuGroup'));
        
    }

    public function postUpdateMenu(Request $request)
    {
        $jsonMenu = json_decode($request->jsonMenu);

        $this->saveMenu($jsonMenu);

        if (!$request->ajax()) {
            return back();
        }

    }

    public function saveMenu($jsonMenu, $parent_id = null)
    {
        $count = 0;
        foreach ($jsonMenu as $item) {
            $menu = Menu::find($item->id);
            if ($menu) {
                $menu->position  = $count;
                $menu->parent_id = $parent_id;
                $menu->save();
                if (!empty($item->children)) {
                    $this->saveMenu($item->children, $menu->id);
                }
            }
            $count++;
        }
    }

    public function getEditItem($id)
    {
        $menu = Menu::find($id);

        if (isset($menu)) {
            $data = [
                'status' => 'success',
                'data'   => $menu,
            ];
        } else {
            $data = [
                'status' => 'error'
            ];
        }

        return response()->json($data);
    }

    public function postEditItem(Request $request)
    {
        $id = $request->id;

        $data = [
            'title' => $request->title,
            'url' => $request->url,
        ];

        Menu::find($id)->update($data);

        return redirect()->back();
    }

    public function getDelete($id)
    {
        Menu::destroy($id);
        
        return back();
    }
}
