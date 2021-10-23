<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class AdminPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = PromotionBanner::all();
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
        $request->validate([
            'Image_eng' => 'required|image',
            'Image_ch'  => 'required|image'
        ], [
            'Image_eng.required' => 'Please Upload English Image',
            'Image_ch.required'  => "Please Upload China Image"
        ]);
        if ($request->hasFile('Image_eng')) {
            $destination = 'Promotion/english';
            if (!file_exists($destination)) {
                Storage::makeDirectory($destination);
            }
            $file = $request->file('Image_eng');
            $img = Image::make($file)->resize(1280, 437);
            $img->save($destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName(), 100);
            $data['image_eng'] = $destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName();
        }

        if ($request->hasFile('Image_ch')) {
            $destination = 'Promotion/china';
            if (!file_exists($destination)) {
                Storage::makeDirectory($destination);
            }
            $file = $request->file('Image_ch');
            $img = Image::make($file)->resize(1280, 437);
            $img->save($destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName(), 100);
            $data['image_ch'] = $destination . "/" . time() . date('d_m_y') . $file->getClientOriginalName();
        }

        PromotionBanner::create($data);
        echo json_encode(['status' => 'success', 'message' => 'Promotion Banner Add Successfully']);
    }

    // delete banner
    public function delete_Banner()
    {
        $banner = PromotionBanner::where('id', request()->id)->first();
        File::delete($banner->image_eng);
        File::delete($banner->image_ch);
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