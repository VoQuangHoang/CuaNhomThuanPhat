<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brands;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Brands\BrandsRepository;
use App\Http\Requests\Admin\StoreBrandsRequest;

class BrandsController extends Controller
{
    protected $brands;

    public function __construct(BrandsRepository $brands)
    {
        $this->brands = $brands;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->can('brand list')){
            $brands = $this->brands->orderBy('name', 'ASC')->get();
            return view("admin.brands.list", compact('brands'));
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
        if(auth()->user()->can('brand add')){
            return view('admin.brands.create');
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandsRequest $request)
    {
        if(auth()->user()->can('brand add')){
            $data = $request->all();
        
            $newBrand = $this->brands->addBrand($data);

            return redirect()->route('brands.index')->with('success', 'Thêm mới thành công');
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
        if(auth()->user()->can('brand edit')){
            $data = $this->brands->findOrFail($id);
            return view('admin.brands.edit', compact('data'));
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
        if(auth()->user()->can('brand edit')){
            $data = $request->all();

            $this->brands->updateBrand($data, $id);

            return redirect()->route('brands.index')->with('success', 'Cập nhật thành công');
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
        if(auth()->user()->can('brand delete')){
            Brands::destroy($id);

            flash('Xóa thành công.')->success()->important();
            
            return redirect()->back();
        }
        abort(406);
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('brand delete')){
            if(!empty($request->chkItem)){

                foreach ($request->chkItem as $id) {
                    Brands::destroy($id);
                }

                return back()->with('success', 'Xóa thành công');
            }
            return back()->with('error', 'Bạn chưa chọn dữ liệu cần xóa.');
        }
        abort(406);
    }
}
