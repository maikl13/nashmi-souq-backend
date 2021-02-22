<?php

namespace App\Http\Controllers\Store;

use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;
use App\DataTables\PromotionsDataTable;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index(PromotionsDataTable $dataTable)
    {
        return $dataTable->render('store-dashboard.promotions.promotions');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'image' => 'required|image|max:8192'
        ]);

        $promotion = new Promotion;
        $promotion->user_id = auth()->user()->id;
        $promotion->url = $request->url;
        
        if($promotion->save()){
            $promotion->image = $promotion->upload_promotion_image($request->image);
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function destroy($store, Promotion $promotion)
    {
        if( $promotion->user_id == auth()->user()->id && $promotion->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}