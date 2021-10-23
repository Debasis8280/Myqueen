<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::leftjoin('categories as category', 'products.category_id', '=', 'category.id')
            ->leftJoin('inventories', 'inventories.productid', '=', 'products.id')
            ->select('products.id', 'products.title', 'products.description', 'products.productimagee', 'products.galleryimagee', 'products.shopbannere', 'products.status', 'products.regularprice', 'products.saleprice', 'products.offerprice', 'products.pagetitle', 'products.usemethod', 'products.size', 'products.metadescription', 'products.metadescription', 'products.metakeyword', 'products.stock', 'products.features', 'products.videotitle', 'category.name as categoryname', 'inventories.stock as istock')
            ->get();

        echo $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = 0;
        return view('admin.inventory.product.product')->with('edit', $edit);
    }

    public function categoryList()
    {
        $data = Category::where('status', 1)->get();
        echo json_encode($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('gallery_imagee')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('gallery_imagee');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['gallery_imagee' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }
        if ($request->hasFile('shop_bannere')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('shop_bannere');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['shop_bannere' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }
        if ($request->hasFile('gallery_imagec')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('gallery_imagec');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['gallery_imagec' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }

        if ($request->hasFile('shop_bannerc')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('shop_bannerc');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['shop_bannerc' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }

        $request->validate([
            'title'                             => 'required|unique:products,title',
            'main_components_image_eng'         => 'nullable|mimes:png,jpg,jpeg',
            'main_components_image_chn'         => 'nullable|mimes:png,jpg,jpeg',
            'product_imagee'                    => 'required|mimes:png,jpg,jpeg',
            'product_imagec'                    => 'required|mimes:png,jpg,jpeg',
            // 'gallery_imagee'                    => 'required|mimes:png,jpg,jpeg',
            // 'gallery_imagec'                    => 'required|mimes:png,jpg,jpeg',
            'effects_image_eng'        => 'nullable|mimes:png,jpg,jpeg',
            'effects_image_chn'        => 'nullable|mimes:png,jpg,jpeg',
            'method_image_eng'        => 'nullable|mimes:png,jpg,jpeg',
            'method_image_chn'        => 'nullable|mimes:png,jpg,jpeg',
            'regular_price'         => 'required|numeric',
            'sale_price'            => 'required|numeric',
            'offer_price'           => 'nullable|numeric',
            'stock'                 => 'required',
            'features'              =>  '',
            'use_method'            => '',
            'page_title'            => '',
            'page_url'              => '',
            "meta_description"      => '',
            'meta_keyword'          => '',
            'video_title'           => '',
            'video_source'          => '',
            'size'                  => 'required',
            'pv_point'              => 'numeric',
            'status'                => 'required',
            'category_id'           => 'required'
        ], [
            'gallery_imagee.required' => 'Please Upload Gallery Image',
            'gallery_imagec.required' => 'Please Upload Gallery Image',
            'title.required'            => 'Please Enter Product Title',
            'product_imagee.required'   => 'Please Upload Product Image',
            'product_imagec.required'   => 'Please Upload Product Image',
            'main_components_image_eng.required'   => 'Please Upload Main Components Image',
            'main_components_image_chn.required'   => 'Please Upload Main Components Image',
            'effects_image_eng.required'   => 'Please Upload Effects Image',
            'effects_image_chn.required'   => 'Please Upload Effects Image',
            'method_image_eng.required'   => 'Please Upload Method Image',
            'method_image_chn.required'   => 'Please Upload Method Image',
            'regular_price.required'    => 'Please Enter Regular Price',
            'sale_price.required'       => 'Please Enter Sale Price',
            'offer_price.required'      => 'Please Enter Offer Price',
            'category_id.required'      => 'Please Select Category',
            'pv_point.required'         => 'Please Enter PV Point',

        ], [

            'product_imagee' => "Product Image ",
            'product_imagec' => "Product Image",
            'main_components_image_eng' => "Main Components Image",
            'main_components_image_chn' => "Main Components Image",
            'effects_image_eng' => "Effects Image",
            'effects_image_chn' => "Effects Image",
            'method_image_eng' => "Method Image",
            'method_image_chn' => "Method Image",
            'regular_price'  => 'Regular Price',
            'sale_price'     => 'Sale Price',
            'offer_price'    => 'Offer Price'

        ]);

        $gallery_imagee = array();
        $gallery_imagec = array();
        $shop_bannere   = array();
        $shop_bannerc   = array();

        $destination = 'product/';
        $main_components_image_eng = null;
        if ($request->hasFile('main_components_image_eng'))
            $main_components_image_eng = $request->main_components_image_eng->move($destination . "/main_components_image_eng", $request->title
                . "_main_components_image_eng" . date('d_m_y_h_m') . "." . $request->main_components_image_eng->getClientOriginalExtension());
        $main_components_image_chn = null;
        if ($request->hasFile('main_components_image_chn'))
            $main_components_image_chn = $request->main_components_image_chn->move($destination . "/main_components_image_chn",  $request->title
                . "_main_components_image_chn" . date('d_m_y_h_m') . "." .  $request->main_components_image_chn->getClientOriginalExtension());

        $effects_image_eng = null;
        $effects_image_chn = null;
        if ($request->hasFile('effects_image_eng'))
            $effects_image_eng = $request->effects_image_eng->move($destination . "/effects_image_eng", $request->title
                . "_effects_image_eng" . date('d_m_y_h_m') . "." . $request->effects_image_eng->getClientOriginalExtension());
        if ($request->hasFile('effects_image_chn'))
            $effects_image_chn = $request->effects_image_chn->move($destination . "/effects_image_chn",  $request->title
                . "_effects_image_chn" . date('d_m_y_h_m') . "." .  $request->effects_image_chn->getClientOriginalExtension());
        $method_image_eng = null;
        if ($request->hasFile('method_image_eng'))
            $method_image_eng = $request->method_image_eng->move($destination . "/method_image_eng", $request->title
                . "_method_image_eng" . date('d_m_y_h_m') . "." . $request->method_image_eng->getClientOriginalExtension());

        $method_image_chn = null;
        if ($request->hasFile('method_image_chn'))
            $method_image_chn = $request->method_image_chn->move($destination . "/method_image_chn",  $request->title
                . "_method_image_chn" . date('d_m_y_h_m') . "." .  $request->method_image_chn->getClientOriginalExtension());

        $product_imagee = Image::make($request->product_imagee)->resize(1088, 663);
        $destination_pro_img_eng = $destination . "/product_imagee";
        if (!file_exists($destination_pro_img_eng)) {
            Storage::makeDirectory($destination_pro_img_eng);
        }
        $product_imagee->save($destination_pro_img_eng . "/" . "product_imagee" .  date('d_m_y_h_m') . $request->title . ".jpg", 100);
        $product_imagee = $destination_pro_img_eng . "/" . "product_imagee" . date('d_m_y_h_m') . $request->title . ".jpg";

        $destination_pro_img_chi = $destination . "/product_imagec";
        if (!file_exists($destination_pro_img_chi)) {
            Storage::makeDirectory($destination_pro_img_chi);
        }
        $product_imagec = Image::make($request->product_imagec)->resize(1088, 663);
        $product_imagec->save($destination_pro_img_chi . "/" . "product_imagec" . date('d_m_y_h_m') . $request->title . ".jpg", 100);
        $product_imagec = $destination_pro_img_chi . "/" . "product_imagec" .  date('d_m_y_h_m') . $request->title . ".jpg";

        if ($request->hasFile('gallery_imagee')) {
            $files = $request->file('gallery_imagee');
            foreach ($files as $file) {
                $destination_gallery_imagee = $destination . "/gallery_imagee";
                if (!file_exists($destination_gallery_imagee)) {
                    Storage::makeDirectory($destination_gallery_imagee);
                }
                $random_n = Str::random(5);
                $gallery_imagee_resize = Image::make($file)->resize(1088, 663);
                $gallery_imagee_resize->save($destination_gallery_imagee . "/" . "gallery_imagee" . date('d_m_y_h_m') . $request->title . $random_n . ".jpg", 100);
                $gallery_imagee[] = $destination_gallery_imagee . "/" . "gallery_imagee" .  date('d_m_y_h_m') . $request->title . $random_n . ".jpg";
            }
        }
        if ($request->hasFile('gallery_imagec')) {
            $files = $request->file('gallery_imagec');
            foreach ($files as $file) {

                $destination_gallery_imagec = $destination . "/gallery_imagec";
                if (!file_exists($destination_gallery_imagec)) {
                    Storage::makeDirectory($destination_gallery_imagec);
                }
                $random_n = Str::random(5);
                $gallery_imagec_resize = Image::make($file)->resize(1088, 663);
                $gallery_imagec_resize->save($destination_gallery_imagec . "/" . "gallery_imagec" . date('d_m_y_h_m') . $request->title . $random_n . ".jpg", 100);
                $gallery_imagec[] = $destination_gallery_imagec . "/" . "gallery_imagec" .  date('d_m_y_h_m') . $request->title . $random_n . ".jpg";
            }
        }
        if ($request->hasFile('shop_bannere')) {
            $files = $request->file('shop_bannere');
            foreach ($files as $file) {
                $random_n = Str::random(5);
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file->move("product/shop_bannere", $request->title . $random_n . "_shop_bannere" .  date('d_m_y_h_m') . "." . $extension);
                $shop_bannere[] = "product/shop_bannere" . '/' .  $request->title . $random_n . "_shop_bannere" . date('d_m_y_h_m') . "." . $extension;
            }
        }
        if ($request->hasFile('shop_bannerc')) {
            $files = $request->file('shop_bannerc');
            foreach ($files as $file) {
                $random_n = Str::random(5);
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file->move("product/shop_bannerc",  $request->title . $random_n . "_shop_bannerc" . date('d_m_y_h_m') . "." . $extension);
                $shop_bannerc[] = "product/shop_bannerc" . '/' .  $request->title . $random_n . "_shop_bannerc" . date('d_m_y_h_m') . "." . $extension;
            }
        }

        Product::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'status'            => $request->status,
            'category_id'       => $request->category_id,
            'regularprice'      => $request->regular_price,
            'saleprice'         => $request->sale_price,
            'offerprice'        => $request->offer_price,
            'pagetitle'         => $request->page_title,
            'pageurl'           => $request->page_url,
            'metadescription'   => $request->meta_description,
            'metakeyword'       => $request->meta_keyword,
            'stock'             => $request->stock,
            'usemethod'         => $request->use_method,
            'size'              => $request->size,
            'pv'                => $request->pv_point,
            'features'          => $request->features,
            'videotitle'        => $request->video_title,
            'videosource'       => $request->video_source,
            'main_components_image_eng'     => $main_components_image_eng,
            'main_components_image_chn'     => $main_components_image_chn,
            'productimagee'     => $product_imagee,
            'productimagec'     => $product_imagec,
            'galleryimagec'     => implode(",", $gallery_imagec),
            'galleryimagee'     => implode(",", $gallery_imagee),
            'shopbannere'       => implode(",", $shop_bannere),
            'shopbannerc'       => implode(",", $shop_bannerc),
            'effects_image_eng'       => $effects_image_eng,
            'effects_image_chn'       => $effects_image_chn,
            'method_image_eng'       => $method_image_eng,
            'method_image_chn'       => $method_image_chn,
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Product Add  Successfully']);
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
        $edit = 1;
        return view('admin.inventory.product.product')->with('edit', $edit);
    }

    // get edit data
    public function get_edit_data()
    {
        $data = Product::find(request()->id);
        echo json_encode($data);
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
        if ($request->hasFile('gallery_imagee')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('gallery_imagee');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['gallery_imagee' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }
        if ($request->hasFile('shop_bannere')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('shop_bannere');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['shop_bannere' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }
        if ($request->hasFile('gallery_imagec')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('gallery_imagec');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['gallery_imagec' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }

        if ($request->hasFile('shop_bannerc')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
            $files = $request->file('shop_bannerc');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $request->validate(['shop_bannerc' => "required|mimes:png,jpg,jpeg"]);
                }
            }
        }

        $request->validate([
            'title'                 => 'required|unique:products,title,' . $id,
            'product_imagee'        => 'nullable|mimes:png,jpg,jpeg',
            'product_imagec'        => 'nullable|mimes:png,jpg,jpeg',
            // 'gallery_imagee'                    => 'required|mimes:png,jpg,jpeg',
            // 'gallery_imagec'                    => 'required|mimes:png,jpg,jpeg',
            'main_components_image_eng'        =>  'nullable|mimes:png,jpg,jpeg',
            'main_components_image_chn'        =>  'nullable|mimes:png,jpg,jpeg',
            'effects_image_eng'     => 'nullable|mimes:png,jpg,jpeg',
            'effects_image_chn'     => 'nullable|mimes:png,jpg,jpeg',
            'method_image_eng'     => 'nullable|mimes:png,jpg,jpeg',
            'method_image_chn'     => 'nullable|mimes:png,jpg,jpeg',
            'regular_price'         => 'required|numeric',
            'sale_price'            => 'required|numeric',
            'offer_price'           => 'nullable|numeric',
            'stock'                 => 'required',
            'features'              =>  '',
            'use_method'            => '',
            'page_title'            => '',
            'page_url'              => '',
            "meta_description"      => '',
            'meta_keyword'          => '',
            'video_title'           => '',
            'video_source'          => '',
            'size'                  => 'required',
            'pv_point'              => 'numeric',
            'status'                => 'required',
            'category_id'           => 'required'
        ], [

            'title.required'            => 'Please Enter Product Title',
            'product_imagee.required'   => 'Please Upload Product Image',
            'product_imagec.required'   => 'Please Upload Product Image',
            'main_components_image_eng.required'   => 'Please Upload Main Components Image',
            'main_components_image_chn.required'   => 'Please Upload Main Components Image',
            'effects_image_eng.required'   => 'Please Upload Effects Image',
            'effects_image_chn.required'   => 'Please Upload Effects Image',
            'method_image_eng.required'   => 'Please Upload Method Image',
            'method_image_chn.required'   => 'Please Upload Method Image',
            'regular_price.required'    => 'Please Enter Regular Price',
            'sale_price.required'       => 'Please Enter Sale Price',
            'offer_price.required'      => 'Please Enter Offer Price',
            'category_id.required'      => 'Please Select Category',
            'pv_point.required'         => 'Please Enter PV Point',

        ], [

            'product_imagee' => "Product Image ",
            'product_imagec' => "Product Image",
            'main_components_image_eng' => "Main Components Image",
            'main_components_image_chn' => "Main Components Image",
            'effects_image_eng' => "Effects Image",
            'effects_image_chn' => "Effects Image",
            'method_image_eng' => "Method Image",
            'method_image_chn' => "Method Image",
            'regular_price'  => 'Regular Price',
            'sale_price'     => 'Sale Price',
            'offer_price'    => 'Offer Price'

        ]);

        $gallery_imagee = array();
        $gallery_imagec = array();
        $shop_bannere   = array();
        $shop_bannerc   = array();

        $not_update = Product::where('id', $id)->first();
        $product_imagee = $not_update->productimagee;
        $product_imagec = $not_update->productimagec;
        $main_components_image_eng = $not_update->main_components_image_eng;
        $main_components_image_chn = $not_update->main_components_image_chn;
        $effects_image_eng = $not_update->effects_image_eng;
        $effects_image_chn = $not_update->effects_image_chn;
        $method_image_eng = $not_update->method_image_eng;
        $method_image_chn = $not_update->method_image_chn;

        if ($request->gallery_imagee == null)
            $gallery_imagee[] = $not_update->galleryimagee;
        if ($request->gallery_imagec == null)
            $gallery_imagec[] = $not_update->galleryimagec;
        if ($request->shop_bannere == null)
            $shop_bannere[]   = $not_update->shopbannere;
        if ($request->shop_bannerc == null)
            $shop_bannerc[]   = $not_update->shopbannerc;

        $destination = 'product/';
        if ($request->hasFile('main_components_image_eng')) {
            File::delete($not_update->main_components_image_eng);
            $main_components_image_eng = $request->main_components_image_eng->move($destination . "/main_components_image_eng", $request->title
                . "_main_components_image_eng" . date('d_m_y_h_m') . "." . $request->main_components_image_eng->getClientOriginalExtension());
        }
        if ($request->hasFile('main_components_image_chn')) {
            File::delete($not_update->main_components_image_chn);
            $main_components_image_chn = $request->main_components_image_chn->move($destination . "/main_components_image_chn",  $request->title
                . "_main_components_image_chn" . date('d_m_y_h_m') . "." .  $request->main_components_image_chn->getClientOriginalExtension());
        }

        if ($request->hasFile('effects_image_eng')) {
            File::delete($not_update->effects_image_eng);
            $effects_image_eng = $request->effects_image_eng->move($destination . "/effects_image_eng", $request->title
                . "_effects_image_eng" . date('d_m_y_h_m') . "." . $request->effects_image_eng->getClientOriginalExtension());
        }
        if ($request->hasFile('effects_image_chn')) {
            File::delete($not_update->effects_image_chn);
            $effects_image_chn = $request->effects_image_chn->move($destination . "/effects_image_chn",  $request->title
                . "_effects_image_chn" . date('d_m_y_h_m') . "." .  $request->effects_image_chn->getClientOriginalExtension());
        }

        if ($request->hasFile('method_image_eng')) {
            File::delete($not_update->method_image_eng);
            $method_image_eng = $request->method_image_eng->move($destination . "/method_image_eng", $request->title
                . "_method_image_eng" . date('d_m_y_h_m') . "." . $request->method_image_eng->getClientOriginalExtension());
        }
        if ($request->hasFile('method_image_chn')) {
            File::delete($not_update->method_image_chn);
            $method_image_chn = $request->method_image_chn->move($destination . "/method_image_chn",  $request->title
                . "_method_image_chn" . date('d_m_y_h_m') . "." .  $request->method_image_chn->getClientOriginalExtension());
        }

        if ($request->hasFile('product_imagee')) {
            File::delete($not_update->product_imagee);

            $product_imagee = Image::make($request->product_imagee)->resize(1088, 663);
            $destination_pro_img_eng = $destination . "/product_imagee";
            $product_imagee->save($destination_pro_img_eng . "/" . "product_imagee" . date('d_m_y_h_m') . $request->title . ".jpg", 100);
            $product_imagee = $destination_pro_img_eng . "/" . "product_imagee" .  date('d_m_y_h_m') . $request->title . ".jpg";
        }
        if ($request->hasFile('product_imagec')) {
            File::delete($not_update->product_imagec);

            $destination_pro_img_chi = $destination . "/product_imagec";
            $product_imagec = Image::make($request->product_imagec)->resize(1088, 663);
            $product_imagec->save($destination_pro_img_chi . "/" . "product_imagec" .  date('d_m_y_h_m') . $request->title . ".jpg", 100);
            $product_imagec = $destination_pro_img_chi . "/" . "product_imagec" .  date('d_m_y_h_m') . $request->title . ".jpg";
        }

        if ($request->hasFile('gallery_imagee')) {

            $delete = explode(',', $not_update->galleryimagee);
            foreach ($delete as $de) {
                File::delete($de);
            }

            $files = $request->file('gallery_imagee');
            foreach ($files as $file) {

                $destination_gallery_imagee = $destination . "/gallery_imagee";
                if (!file_exists($destination_gallery_imagee)) {
                    Storage::makeDirectory($destination_gallery_imagee);
                }
                $random_n = Str::random(5);
                $gallery_imagee_resize = Image::make($file)->resize(1088, 663);
                $gallery_imagee_resize->save($destination_gallery_imagee . "/" . "gallery_imagee" . date('d_m_y_h_m') . $request->title . $random_n . ".jpg", 100);
                $gallery_imagee[] = $destination_gallery_imagee . "/" . "gallery_imagee" .  date('d_m_y_h_m') . $request->title . $random_n . ".jpg";

                // $filename = $file->getClientOriginalName();
                // $extension = $file->getClientOriginalExtension();
                // $file->move('public/image/product/gallery_imagee',  $request->title . "_gallery_imagee" . date('d_m_y_h_m') . "." .  $extension);
                // $gallery_imagee[] = "public/image/product/gallery_imagee" . '/' . $request->title . "_gallery_imagee" . date('d_m_y_h_m') . "." .  $extension;
            }
        }
        if ($request->hasFile('gallery_imagec')) {

            $delete = explode(',', $not_update->galleryimagec);
            foreach ($delete as $de) {
                File::delete($de);
            }

            $files = $request->file('gallery_imagec');
            foreach ($files as $file) {

                $destination_gallery_imagec = $destination . "/gallery_imagec";
                if (!file_exists($destination_gallery_imagec)) {
                    Storage::makeDirectory($destination_gallery_imagec);
                }
                $random_n = Str::random(5);
                $gallery_imagec_resize = Image::make($file)->resize(1088, 663);
                $gallery_imagec_resize->save($destination_gallery_imagec . "/" . "gallery_imagec" . date('d_m_y_h_m') . $request->title . $random_n . ".jpg", 100);
                $gallery_imagec[] = $destination_gallery_imagec . "/" . "gallery_imagec" .  date('d_m_y_h_m') . $request->title . $random_n . ".jpg";


                // $filename = $file->getClientOriginalName();
                // $extension = $file->getClientOriginalExtension();
                // $file->move("public/image/product/gallery_imagec", $request->title . "_gallery_imagec" . date('d_m_y_h_m') . "." . $extension);
                // $gallery_imagec[] = "public/image/product/gallery_imagec" . '/' .  $request->title . "_gallery_imagec" . date('d_m_y_h_m') . "." . $extension;
            }
        }
        if ($request->hasFile('shop_bannere')) {

            $delete = explode(',', $not_update->shopbannere);
            foreach ($delete as $de) {
                File::delete($de);
            }

            $files = $request->file('shop_bannere');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file->move("public/image/product/shop_bannere", $request->title . "_shop_bannere" .  date('d_m_y_h_m') . "." . $extension);
                $shop_bannere[] = "public/image/product/shop_bannere" . '/' .  $request->title . "_shop_bannere" . date('d_m_y_h_m') . "." . $extension;
            }
        }
        if ($request->hasFile('shop_bannerc')) {

            $delete = explode(',', $not_update->shopbannerc);
            foreach ($delete as $de) {
                File::delete($de);
            }

            $files = $request->file('shop_bannerc');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file->move("public/image/product/shop_bannerc",  $request->title . "_shop_bannerc" . time() . "." . $extension);
                $shop_bannerc[] = "public/image/product/shop_bannerc" . '/' .  $request->title . "_shop_bannerc" . time() . "." . $extension;
            }
        }

        Product::where('id', $id)->update([
            'title'             => $request->title,
            'description'       => $request->description,
            'status'            => $request->status,
            'category_id'       => $request->category_id,
            'regularprice'      => $request->regular_price,
            'saleprice'         => $request->sale_price,
            'offerprice'        => $request->offer_price,
            'pagetitle'         => $request->page_title,
            'pageurl'           => $request->page_url,
            'metadescription'   => $request->meta_description,
            'metakeyword'       => $request->meta_keyword,
            'stock'             => $request->stock,
            'usemethod'         => $request->use_method,
            'size'              => $request->size,
            'pv'                => $request->pv_point,
            'features'          => $request->features,
            'videotitle'        => $request->video_title,
            'videosource'       => $request->video_source,
            'productimagee'     => $product_imagee,
            'productimagec'     => $product_imagec,
            'main_components_image_eng'     => $main_components_image_eng,
            'main_components_image_chn'     => $main_components_image_chn,
            'effects_image_eng'     => $effects_image_eng,
            'effects_image_chn'     => $effects_image_chn,
            'method_image_eng'     => $method_image_eng,
            'method_image_chn'     => $method_image_chn,
            'galleryimagec'     => implode(",", $gallery_imagec),
            'galleryimagee'     => implode(",", $gallery_imagee),
            'shopbannere'       => implode(",", $shop_bannere),
            'shopbannerc'       => implode(",", $shop_bannerc),
            'created_at'        => now(),
            'updated_at'        => now()
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Product Update  Successfully']);
    }

    // delete product
    public function deleteProduct()
    {
        $data = Product::where('id', request()->id)->first();
        if ($data->productimagee)
            File::delete($data->productimagee);
        if ($data->productimagec)
            File::delete($data->productimagec);
        if ($data->main_components_image_eng)
            File::delete($data->main_components_image_eng);
        if ($data->main_components_image_chn)
            File::delete($data->main_components_image_chn);
        if ($data->effects_image_eng)
            File::delete($data->effects_image_eng);
        if ($data->effects_image_chn)
            File::delete($data->effects_image_chn);
        if ($data->method_image_eng)
            File::delete($data->method_image_eng);
        if ($data->method_image_chn)
            File::delete($data->method_image_chn);
        if ($data->galleryimagec)
            foreach (explode(',', $data->galleryimagec) as $item) {
                File::delete($item);
            }

        if ($data->galleryimagee)
            foreach (explode(',', $data->galleryimagee) as $item) {
                File::delete($item);
            }
        if ($data->shopbannere)
            foreach (explode(',', $data->shopbannere) as $item) {
                File::delete($item);
            }
        if ($data->shopbannerc)
            foreach (explode(',', $data->shopbannerc) as $item) {
                File::delete($item);
            }

        Product::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Product Delete Successfully']);
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