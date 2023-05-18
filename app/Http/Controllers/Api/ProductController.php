<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //   public function show($store, Product $product,Request $request)
    // {
    //     $product->views = $product->views+1;
    //     $product->save();
    //   //  $product = Product::find($request->slug);
    // $options = [];
    // $vs = [];
    // $added_values = [];
    // $used_ps = [];
    // foreach (optional($product->options)['values'] ?? [] as $value) {
    //     $option = optional(OptionValue::find($value))->option_id;
    //     $nameoption=Option::find($option);
    //     $r=$nameoption->name;

    //      $optionArray = [
    //             'id'=>$option,
    //             'name' => $r,
    //             'values' => []
    //         ];
    //     // if($r){
    //     //     $nameop=$r;
    //     // }else{
    //     //     $nameop=$option;
    //     // }
    //     if ($option) {
    //         $ps = Product::whereGroup($product->group)->whereJsonContains('options->options', $option);
    //         if($vs) $ps = $ps->whereJsonContains('options->values', $vs);
    //         $ps = $ps->get();
    //         $vs[] = $value;
    //         foreach ($ps as $p) {
    //             foreach (optional($p->options)['values'] ?? [] as $v) {
    //                 $v = OptionValue::find($v);
    //                 if ($v) {
    //                     if($v && $v->option_id == $option && !in_array($v->id, $added_values)){
    //                         $value = [];
    //                         $value['value'] = $v;
    //                         $value['url'] = $p->url_api();
    //                         $value['product_id']=$p->id;
    //                         $value['image'] = $p->product_image(['size' => 'xxxs']);
    //                         $optionArray['values'][] = $value;
    //                         $added_values[] = $v->id;
    //                         $used_ps[] = $p->id;
    //                     }
    //                 }
    //             }
    //             $options[]=$optionArray;
    //         }
    //     }
    // }
    // $related_ps = sizeof($options)>1 || Product::whereGroup($product->group)->count() == 1 ?  Product::whereId(0):
    //     Product::whereGroup($product->group)->whereNotIn('id', $used_ps)->get();
    // return response()->json(['product'=>$product,'options'=>$options],200);
    // //  $optionsu=$product->options;

    // //     $response = [];
    // //     foreach ($optionsu["options"] as $option) {
    // //     $options = Option::with('option_values')->find($option);
    // //         $optionArray = [
    // //             'id'=>$options->id,
    // //             'name' => $options->name,
    // //             'values' => []
    // //         ];

    // //         foreach ($optionsu["values"] as $v) {
    // //             $optionvaalues = OptionValue::find($v);
    // //             if($optionvaalues->option_id==$option){

    // //             $optionArray['values'][] = [
    // //                 'id' => $optionvaalues->id,
    // //                 'name' => $optionvaalues->name,
    // //                 'image' => $optionvaalues->image,
    // //                 'option_id' => $options->id,
    // //                 'value_id' => $optionvaalues->id,
    // //                 'color'=>$optionvaalues->color,
    // //                 'url'=>url('api/products/'.$product->slug)
    // //             ];

    // //          }
    // //     }

    // //         $response[] = $optionArray;
    // //     }

    // //     return response()->json(['product_info'=>$product,'options'=>$response]);

    // }

    public function show($store, Product $product, Request $request)
    {
        $product->views = $product->views + 1;
        $product->save();
        //   return $product->with('category:id,name','currency:id,name,code')->get();
        $options = [];
        $vs = [];
        $added_values = [];
        $used_ps = [];
        $added_options = []; // Initialize the array to store added options

        foreach (optional($product->options)['values'] ?? [] as $value) {
            $option = optional(OptionValue::find($value))->option_id;
            $nameoption = Option::find($option);
            $r = $nameoption->name;

            // Initialize the option array inside the loop to ensure a new array is created for each option
            $optionArray = [
                'id' => $option,
                'name' => $r,
                'values' => [],
            ];

            // Check if the option has already been added
            if (! in_array($option, $added_options)) {
                // Option has not been added yet, so you can add it now
                $added_options[] = $option;

                if ($option) {
                    $ps = Product::whereGroup($product->group)->whereJsonContains('options->options', $option);
                    if ($vs) {
                        $ps = $ps->whereJsonContains('options->values', $vs);
                    }
                    $ps = $ps->get();
                    $vs[] = $value;
                    foreach ($ps as $p) {
                        foreach (optional($p->options)['values'] ?? [] as $v) {
                            $v = OptionValue::find($v);
                            if ($v) {
                                if ($v && $v->option_id == $option && ! in_array($v->id, $added_values)) {
                                    $value = [];
                                    $value['value'] = $v;
                                    $value['url'] = $p->url_api();
                                    $value['product_id'] = $p->id;
                                    $value['image'] = $p->product_image(['size' => 'xxxs']);
                                    $optionArray['values'][] = $value;
                                    $added_values[] = $v->id;
                                    $used_ps[] = $p->id;
                                }
                            }
                        }
                    }
                    // Add the option array to options here, outside of the inner loop
                    $options[] = $optionArray;
                }
            }
        }
        $related_ps = count($options) > 1 || Product::whereGroup($product->group)->count() == 1 ? Product::whereId(0) :
            Product::whereGroup($product->group)->whereNotIn('id', $used_ps)->get();
        $reult = $product->load('category:id,name', 'currency:id,name,code');

        return response()->json(['product' => $product, 'options' => $options], 200);
    }
}
