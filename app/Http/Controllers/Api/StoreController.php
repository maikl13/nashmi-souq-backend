<?php

namespace App\Http\Controllers\Api;


use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;


class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing()
    {
      $prices=[
                    [
                        'name' => 'شهري',
                        'price' => ceil(exchange(setting('monthly_subscription'), 'USD', currency_api()->code)),
                    ], [
                        'name' => 'نصف سنوي',
                        'price' => ceil(exchange(setting('half_year_subscription'), 'USD', currency_api()->code)),
                        'discount' => setting('monthly_subscription') ? round((1-((setting('half_year_subscription')/6)/setting('monthly_subscription')))*100, 1) : 0
                    ], [
                        'name' => 'سنوي',
                        'price' => ceil(exchange(setting('yearly_subscription'), 'USD', currency_api()->code)),
                        'discount' => setting('yearly_subscription') ? round((1-((setting('yearly_subscription')/12)/setting('monthly_subscription')))*100, 1) : 0
                    ]
                ];
      
        return response()->json(['data'=>$prices],200);
       
    }
    
    
   

   
    

  
    
    
    
    
    
}
