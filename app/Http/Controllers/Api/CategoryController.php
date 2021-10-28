<?php

namespace App\Http\Controllers\Api;

use Str;
use App\Models\Option;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $categories=Category::whereNull('category_id')->with('children')->get();
        return response()->json(['data'=>$categories],200);
       
    }
    
    public function brands()
    {
       $categories=Brand::paginate(15);
        return response()->json(['data'=>$categories],200);
       
    }
    
    public function category_brands($id)
    {
        $brands=[];
        foreach(Brand::get() as $b){
            if(in_array($id,json_decode(json_encode($b->categories)))){
                $brands[]=$b;
            }
        }
      
        return response()->json(['data'=>$brands],200);
       
    }
    
    public function models_brand($id)
    {
        $brand=Brand::find($id);
        
        return response()->json(['data'=>$brand->children()->get()],200);
       
    }
    
    
    
    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
  


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    

    public function sub_categories($id){
         $categories=Category::where('category_id',$id)->get();
        return response()->json(['data'=>$categories],200);
      
    }
    
    public function category_options($id)
    {
        $options = Option::whereJsonContains('categories', "{$id}");
        $category=Category::find($id);
        while ($category->parent) {
            $category = $category->parent;
            $options = $options->orWhereJsonContains('categories', "{$category->id}");
        }

        $options = $options->with('option_values')->get();
        
     return response()->json(['data'=>$options],200);
    }
    
    public function listing_types(){
        $types = [
                                        'بيع',
                                        'شراء',
                                        'تبديل',
                                       'إيجار',
                                        'عرض وظيفة',
                                         'طلب وظيفة'
                                    ];
                                    
        return response()->json(['data'=>$types],200);     
       
    }
    public function listing_states(){
         $states = country() ? country()->states : [];
         return response()->json(['data'=>$states],200);     
        
    }
    
    
    
    
    
}
