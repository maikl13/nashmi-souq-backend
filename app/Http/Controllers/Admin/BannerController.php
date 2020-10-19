<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BannersDataTable;
use Carbon\Carbon;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BannersDataTable $dataTable)
    {
        return $dataTable->render('admin.banners.banners');
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
            'type' => 'required|in:'.Banner::TYPE_LARGE_RECTANGLE.','.Banner::TYPE_LEADERBOARD.','.Banner::TYPE_LARGE_LEADERBOARD.','.Banner::TYPE_MOBILE_BANNER,
            'url' => 'url',
            'image' => 'required|image|max:8192'
        ]);

        $banner = new Banner;
        $banner->type = $request->type;
        $banner->url = $request->url;
        $banner->period = $request->period;
        $banner->expires_at = Carbon::now()->addDays( $request->period );

        if($banner->save()){
            $banner->image = $banner->upload_banner_image($request->image, $banner->width(), $banner->height());
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(banner $banner)
    {
        return view('admin.banners.edit-banner')->with('banner', $banner);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, banner $banner)
    {
        $request->validate([
            'type' => 'required|in:'.Banner::TYPE_LARGE_RECTANGLE.','.Banner::TYPE_LEADERBOARD.','.Banner::TYPE_LARGE_LEADERBOARD.','.Banner::TYPE_MOBILE_BANNER,
            'url' => 'url',
            'image' => 'image|max:8192',
        ]);

        if($request->image){
            $banner->type = $request->type;
            $banner->delete_file('image');
        } elseif ($banner->type != $request->type) {
            return redirect()->back()->with('failure', 'لتغيير نوع البانر برجاء إختيار الصورة المطلوبة مره أخرى, لا يمكن استخدام نفس الصورة المرفوعة مسبقا');
        }
        $banner->url = $request->url;
        if($request->period != $banner->period){
            $banner->expires_at = $banner->expires_at->addDays( $request->period - $banner->period );
            $banner->period = $request->period;
        }

        if($banner->save()){
            $banner->image = $banner->upload_banner_image($request->image, $banner->width(), $banner->height());
            return redirect()->route('banners')->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(banner $banner)
    {
        if( $banner->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
