<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\FeaturedListing;
use App\Models\Listing;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\State;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ListingsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type.*' => 'nullable|in:'.Listing::TYPE_SELL.','.Listing::TYPE_BUY.','.Listing::TYPE_EXCHANGE.','.Listing::TYPE_JOB.','.Listing::TYPE_RENT,
            'categories.*' => 'nullable|exists:categories,id',
            'sub_categories.*' => 'nullable|exists:categories,id',
            'states.*' => 'nullable|exists:states,id',
            'areas.*' => 'nullable|exists:areas,id',
        ]);

        $listings = Listing::query()->apilocalized()->active();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;
        $states = empty($request->states) || $request->states == [null] ? [] : $request->states;
        $areas = empty($request->areas) || $request->areas == [null] ? [] : $request->areas;
        $types = empty($request->type) || $request->type == [null] ? [] : $request->type;

        //search
        /*if($request->q && !empty($request->q))
            $listings = $listings->search($request->q)->featuredOrFixedFirst();*/
        // filter by type

        //$listings = $listings->where('type', $request->type);

        // filter by category
        if (! empty($categories) || ! empty($sub_categories)) {
            $listings = $listings->where(function ($query) use ($categories, $sub_categories) {
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            })->featuredOrFixedFirst();
        }

        // filter by location
        if (! empty($states) || ! empty($areas)) {
            $listings = $listings->Where(function ($query) use ($states, $areas) {
                $query->whereIn('state_id', $states)
                    ->orWhereIn('area_id', $areas);
            });
        }

        if (! empty($types)) {
            $listings = $listings->Where(function ($query) use ($types) {
                $query->whereIn('type', $types);
            });
        }

        $listings = $listings->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }

    public function search_listings(Request $request, $code)
    {
        $country = Country::where('code', $code)->first();

        if ($country) {
            $validator = Validator::make($request->all(), [
                'q' => 'sometimes',
                'area_id' => 'sometimes',
                'state_id' => 'sometimes',
                'category_id' => 'sometimes',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
            }

            $query = Listing::query();

            if (request()->has('q')) {
                $query->search($request->q)->featuredOrFixedFirst();
            }
            if (request()->has('area_id')) {
                $query->where('area_id', 'like', $request->area_id);
            }
            if (request()->has('state_id')) {
                $query->where('state_id', 'like', $request->state_id);
            }
            if (request()->has('category_id')) {
                $query->where('category_id', 'like', $request->category_id);
            }

            $listings = $query->whereIn('state_id', $country->states()->pluck('id')->toArray())
            ->with(['user', 'currency:id,name,code', 'state:id,name', 'area:id,name', 'category:id,name', 'sub_category'])
             ->latest()->paginate(15);

            return response()->json(['data' => $listings]);
        } else {
            return response()->json(['data' => 'لا يوجد بلد بهذا الكود']);
        }

        // $listings = Listing::query()->apilocalized()->active();
        // $listings = $listings->search($request->q)->featuredOrFixedFirst();
        // $listings = $listings->with(['user','currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->paginate(15);

        // return response()->json(['data' => $listings]);
    }

    public function related_listings($id)
    {
        $listing = Listing::find($id);
        $listings = Listing::where('category_id', $listing->category_id)->localized()->active()->featuredFirst()->where('listings.id', '!=', $listing->id);

        $listings = $listings->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->limit(10)->get();

        return response()->json(['data' => $listings]);
    }

    public function category_listings($id)
    {
        $listings = Listing::where('category_id', $id)->apilocalized()->active()->featuredFirst();

        $listings = $listings->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }

    public function id_listings($id)
    {
        $listings = Listing::with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->findorFail($id);

        $response = [];
        if (! $listings->options != '[]') {
            $optionsu = $listings->options;
            $options = [];
            foreach ($optionsu['options'] as $option) {
                $optionData = Option::with('option_values')->find($option);
                $optionArray = [
                    'id' => $optionData->id,
                    'name' => $optionData->name,
                    'values' => [],
                ];
                foreach ($optionsu['values'] as $v) {
                    $optionvaalues = OptionValue::find($v);
                    if ($optionvaalues->option_id == $option) {
                        $optionArray['values'][] = [
                            'id' => $optionvaalues->id,
                            'name' => $optionvaalues->name,
                            'image' => $optionvaalues->image,
                            'option_id' => $optionData->id,
                            'value_id' => $optionvaalues->id,
                        ];
                    }
                }
                $options[] = $optionArray;
            }
            $response[] = [
                'data' => $listings,
                'options' => $options,
            ];
        } else {
            $response[] = [
                'data' => $listings,
                'options' => [],
            ];
        }

        return response()->json($response);
    }

    public function sub_category_listings($id)
    {
        $listings = Listing::where('sub_category_id', $id)->apilocalized()->active()->featuredFirst();

        $listings = $listings->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }

    public function user_listings($id)
    {
        $listings = Listing::where('user_id', $id)->active()->featuredFirst()
   ->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])
    ->latest()->paginate(15);

        $response = [];
        foreach ($listings as $listing) {
            if (! $listing->options != '[]') {
                $optionsu = $listing->options;
                $options = [];
                foreach ($optionsu['options'] as $option) {
                    $optionData = Option::with('option_values')->find($option);
                    $optionArray = [
                        'id' => $optionData->id,
                        'name' => $optionData->name,
                        'values' => [],
                    ];
                    foreach ($optionsu['values'] as $v) {
                        $optionvaalues = OptionValue::find($v);
                        if ($optionvaalues->option_id == $option) {
                            $optionArray['values'][] = [
                                'id' => $optionvaalues->id,
                                'name' => $optionvaalues->name,
                                'image' => $optionvaalues->image,
                                'option_id' => $optionData->id,
                                'value_id' => $optionvaalues->id,
                            ];
                        }
                    }
                    $options[] = $optionArray;
                }
                $response[] = [
                    'data' => $listing,
                    'options' => $options,
                ];
            } else {
                $response[] = [
                    'data' => $listing,
                    'options' => [],
                ];
            }
        }

        return response()->json($response);
    }

    public function country_listings($code)
    {
        $country = Country::where('code', $code)->first();

        if ($country) {
            $listings = Listing::whereIn('state_id', $country->states()->pluck('id')->toArray())->active()->featuredFirst();
            $listings = $listings->with(['user', 'currency:id,name,code', 'comments', 'state', 'area', 'category:id,name', 'sub_category'])->latest()->paginate(15);

            return response()->json(['data' => $listings]);
        } else {
            return response()->json(['data' => 'لا يوجد بلد بهذا الكود']);
        }
    }

     public function pinned_ads($code)
     {
         $country = Country::where('code', $code)->first();
         if ($country) {
             $fixed_listings = Listing::where('state_id', $country->states()->pluck('id')->toArray())->with('user', 'comments', 'state', 'area', 'sub_category', 'currency:id,name,code', 'category:id,name')->fixed()->active()->inRandomOrder()->get(); //->localized()

             if (count($fixed_listings)) {
                 return response()->json(['data' => $fixed_listings]);
             } else {
                 return response()->json(['data' => 'لا توجد بيانات']);
             }
         } else {
             return response()->json(['data' => 'لا يوجد بلد بهذا الكود']);
         }
     }

      public function featurepromote($id, Request $request)
      {
          $listingId = $id;
          $r = $request->code;
          //  return $r;
          $countrycode = Country::where('code', $r)->first();
          // return $countrycode->currency_id;
          $currencycode = Currency::where('id', $countrycode->currency_id)->first();
          $listings = Listing::with('currency')->findOrFail($id);
          $user = Auth::user();
          $currentBalance = $user->payout_balance();

          $currencyCode = $currencycode->code;

          $message = '';
          if ($currentBalance) {
              $message = "رصيدك المتاح حاليا <strong><span class='current-balance'>".$currentBalance.'</span> '.$currencyCode.'</strong>, هل أنت بحاجة للمزيد لترقية إعلانك بالشكل المطلوب';
          } else {
              $message = 'ليس لديك رصيد بالمحفظة';
          }

          $benefits = setting('featured_ads_benefits');
          // $currentBalance = Auth::user()->payout_balance();
          //  $currencyCode = currency_api()->code;
          $tiersTitles = ['يوم', '3 أيام', 'أسبوع', '15 يوم', 'شهر', '3 شهور', '6 شهور', 'سنة'];

          $tiers = [];
          for ($i = 1; $i <= 8; $i++) {
              if (! empty(setting('tier'.$i))) {
                  $tier = [];
                  $tier['index'] = $i;
                  $tier['title'] = $tiersTitles[$i - 1];
                  $tier['value'] = setting('tier'.$i) + 0;
                  $tier['price'] = round(exchange($tier['value'], 'USD', $currencyCode), 1);
                  $tier['currency'] = $currencycode->code;
                  $tiers[] = $tier;
              }
          }
          if ($listings->currency) {
              $pricecode = $listings->price.$listings->currency->code;
          } else {
              $pricecode = $listings->price;
          }

          return response()->json([
              'benefits' => $benefits,
              'message' => strip_tags($message),
              'current_balance' => $currentBalance,
              'currency_code' => $currencyCode,
              'tiers' => $tiers,
              // 'listing_id' => $listingId,
              // 'price'=>$pricecode,
          ]);
      }

    public function pinads($id, Request $request)
    {
        $listingId = $id;
        $r = $request->code;
        //  return $r;
        $countrycode = Country::where('code', $r)->first();
        // return $countrycode->currency_id;
        $currencycode = Currency::where('id', $countrycode->currency_id)->first();
        $listings = Listing::with('currency')->findOrFail($id);
        $user = Auth::user();
        $currentBalance = $user->payout_balance();

        $currencyCode = $currencycode->code;

        $message = '';
        if ($currentBalance) {
            $message = "رصيدك المتاح حاليا <strong><span class='current-balance'>".$currentBalance.'</span> '.$currencyCode.'</strong>هل أنت بحاجة للمزيد لتثبيت اعلانك';
        } else {
            $message = 'ليس لديك رصيد بالمحفظة';
        }

        $benefits = setting('featured_ads_benefits2');
        $tiers_titles = ['شهر ', 'شهرين', '3 شهور', '4 شهور', '5 شهور', '6 شهور', '7 شهور', '8 شهور', '9 شهور', '10 شهور', '11 شهر', '12 شهور'];
        $tiers = [];
        for ($i = 9; $i <= 20; $i++) {
            if (! empty(setting('tier'.$i))) {
                $tier = [];
                $tier['index'] = $i;
                $tier['title'] = $tiers_titles[$i - 9];
                $tier['value'] = setting('tier'.$i) + 0;
                $tier['price'] = round(exchange($tier['value'], 'USD', $currencyCode), 1);
                $tier['currency'] = $currencycode->code;
                $tiers[] = $tier;
            }
        }

        return response()->json(['benefits' => $benefits,
            'message' => strip_tags($message),
            'current_balance' => $currentBalance,
            'currency_code' => $currencyCode,
            'tiers' => $tiers,
        ]);
    }

      public function promote(Request $request)
      {
          // dd($request->request);
          $request->validate([
              'listing_id' => 'required|exists:listings,id',
              'tier' => 'required|between:1,20',
          ]);
          $listing = Listing::where('id', $request->listing_id)->first();
          $price = round(exchange(setting('tier'.$request->tier), 'USD', currency()->code), 1);

          $this->authorize('edit', $listing);
          if ($listing->is_featured() && $request->tier <= 8) {
              return response()->json('تم ترقية الإعلان بالفعل للعضوية المميزة من قبل', 200);
          }

          if ($listing->is_fixed() && $request->tier >= 9) {
              return response()->json('الاعلان مثبت بالفعل', 403);
          }

          if (empty(setting('tier'.$request->tier))) {
              return response()->json('حدث خطأ ما! قم بتحديث الصفحة و حاول مجددا.', 500);
          }

          if (Auth::user()->payout_balance() < $price) {
              return response()->json('عفوا رصيدك الحالي لا يكفي لإتمام العملية.', 403);
          }

          $featured_listing = new FeaturedListing;
          $featured_listing->listing_id = $listing->id;
          $featured_listing->tier = $request->tier;
          $featured_listing->expired_at = \Carbon\Carbon::now()->addDays($featured_listing->period());

          $featured_listing->price = $price;
          $featured_listing->currency_id = currency()->id;

          $transaction = $featured_listing->payment_init($price, currency());

          if ($successfull_transaction = $featured_listing->pay_from_wallet($transaction)) {
              $featured_listing->transaction_id = $transaction->id;
              if ($featured_listing->save()) {
                  if ($request->tier <= 8) {
                      return response()->json('تم ترقية إعلانك لإعلان مميز بنجاح.', 200);
                  }

                  return response()->json('تم تثبيت إعلانك بنجاح.', 200);
              }
          } else {
              return response()->json('حدث خطأ ما! من فضلك تأكد من وجود رصيد كاف و حاول مجددا.', 500);
          }

          return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
      }
}
