<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:'.Banner::TYPE_LARGE_RECTANGLE.','.Banner::TYPE_LEADERBOARD.','.Banner::TYPE_LARGE_LEADERBOARD.','.Banner::TYPE_MOBILE_BANNER,
            'url' => 'url',
            'image' => 'required|image|max:8192',
            'countries.*' => 'exists:countries,id',
        ]);

        $banner = new Banner;
        $banner->type = $request->type;
        $banner->url = $request->url;
        $banner->period = $request->period;
        $banner->expires_at = Carbon::now()->addDays($request->period);
        $banner->countries = $request->countries;

        if ($banner->save()) {
            $banner->image = $banner->upload_banner_image($request->image, $banner->width(), $banner->height());

            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(banner $banner)
    {
        return view('admin.banners.edit-banner')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, banner $banner)
    {
        $request->validate([
            'type' => 'required|in:'.Banner::TYPE_LARGE_RECTANGLE.','.Banner::TYPE_LEADERBOARD.','.Banner::TYPE_LARGE_LEADERBOARD.','.Banner::TYPE_MOBILE_BANNER,
            'url' => 'url',
            'image' => 'image|max:8192',
            'countries.*' => 'exists:countries,id',
        ]);

        if ($request->image) {
            $banner->type = $request->type;
            $banner->delete_file('image');
        } elseif ($banner->type != $request->type) {
            return redirect()->back()->with('failure', 'لتغيير نوع البانر برجاء إختيار الصورة المطلوبة مره أخرى, لا يمكن استخدام نفس الصورة المرفوعة مسبقا');
        }
        $banner->url = $request->url;
        $banner->countries = $request->countries;
        if ($request->period != $banner->period) {
            $banner->expires_at = $banner->expires_at->addDays($request->period - $banner->period);
            $banner->period = $request->period;
        }

        if ($banner->save()) {
            $banner->image = $banner->upload_banner_image($request->image, $banner->width(), $banner->height());

            return redirect()->route('banners')->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(banner $banner)
    {
        if ($banner->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
