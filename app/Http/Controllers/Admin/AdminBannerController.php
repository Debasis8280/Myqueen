<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class AdminBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Banner::all();
        echo $data;
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
            'Image_eng' => 'required|image',
            'Image_ch'  => 'required|image'
        ], [
            'Image_eng.required' => 'Please Upload English Image',
            'Image_ch.required'  => "Please Upload China Image"
        ]);
        if ($request->hasFile('Image_eng')) {
            $destination = 'Banner/english';
            if (!file_exists($destination)) {
                Storage::makeDirectory($destination);
            }
            $file = $request->file('Image_eng');
            $img = Image::make($file)->resize(1280, 437);
            $img->save($destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName(), 100);
            $data['Image_eng'] = $destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName();
        }

        if ($request->hasFile('Image_ch')) {
            $destination = 'Banner/china';
            if (!file_exists($destination)) {
                Storage::makeDirectory($destination);
            }
            $file = $request->file('Image_ch');
            $img = Image::make($file)->resize(1280, 437);
            $img->save($destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName(), 100);
            $data['Image_ch'] = $destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName();
        }

        Banner::create($data);
        echo json_encode(['status' => 'success', 'message' => 'Banner Add Successfully']);
    }

    // delete banner
    public function deleteBanner()
    {
        $banner = Banner::where('id', request()->id)->first();
        File::delete($banner->Image_eng);
        File::delete($banner->Image_ch);
        $banner->delete();
        echo json_encode(['status' => 'success', 'message' => 'Banner Delete Successfully']);
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