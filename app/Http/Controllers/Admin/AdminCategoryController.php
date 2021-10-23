<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('id', 'desc')->get();
        echo $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|unique:categories',
            'slug'          => '',
            'description'   => '',
            'status'        => 'required',
            'image'         => $request->image != null ? 'required|image' : ''
        ], [
            'name.required'     => 'Please Enter Name',
            'status.required'   => 'Please Select Status'
        ]);
        if ($request->hasFile('image')) {
            $destination = 'category/';
            $file = $request->file('image');
            $file->move($destination, time() . $file->getClientOriginalName());
            $data['image'] =  $destination . '/' . time() . $file->getClientOriginalName();
        }

        Category::create($data);
        echo json_encode(['status' => 'success', 'message' => 'Category Create Successfully']);
    }

    // show edit data
    public function showEditData()
    {
        $data = Category::where('id', request()->id)->first();
        echo json_encode($data);
    }

    // update category
    public function updateCategory(Request $request)
    {
        $data = $request->validate([
            'id'            => 'required',
            'name'          => 'required|unique:categories,name,' . $request->id,
            'slug'          => '',
            'description'   => '',
            'status'        => 'required',
            'image'         => $request->image != null ? 'required|image' : ''
        ], [
            'name.required'     => 'Please Enter Name',
            'status.required'   => 'Please Select Status'
        ]);

        if ($request->hasFile('image')) {
            $delete = Category::where('id', $request->id)->first();
            File::delete($delete->image);
            $destination = 'category/';
            $file = $request->file('image');
            $file->move($destination, time() . $file->getClientOriginalName());
            $data['image'] =  $destination . '/' . time() . $file->getClientOriginalName();
        }

        Category::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'Category Update Successfully']);
    }

    // delete category
    public function deleteCategory()
    {
        $delete = Category::where('id', request()->id)->first();
        File::delete($delete->image);
        Category::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Category Delete Successfully']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}