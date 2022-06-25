<?php

namespace App\Http\Controllers\Main;

use App\Models\Listing;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $listings = Listing::localized()->active()->featuredFirst()->paginate(8)->shuffle();
        // featured first and exclude fixed
        $listings = Listing::localized()->active()->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*', 
                'featured_listings.listing_id', 
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` >= 9, 1, 0) as `listed`"),
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` < 9, 1, 0) as `featured`"),
            )
            ->orderByRaw('`featured` desc, `listed` asc, `id` desc');
        

        if (request()->ajax() && request()->_ajax){
            $listings = $listings->paginate(12);
            return response()->json(view('main.layouts.partials.home-listings', ['listings' => $listings])->render(), 200);

        } else {
            $limit = (request()->page ?? 1) * 12;
        
            if($limit <= 40) {
                $listings = $listings->limit($limit)->get();
            } else {
                $listings = $listings->paginate(12);
            }
        }

        return view('main.home', ['listings' => $listings]);
    }

    public function test()
    {
        // $sid    = "AC4d054e9be947b96f2078aa6c9666fb19"; 
        // $token  = "cd5cbf750833ef37b38f0eb62e50ccd5"; 
        // $twilio = new Client($sid, $token); 
        // $message = $twilio->messages->create("+201114587245", [
        //     "messagingServiceSid" => "MGfd46f7144ec5e71cad3ab9e2a8f24e68",      
        //     "body" => "test" 
        // ]); 

        // print($message->sid);
    }


    public function privacy_policy()
    {
        return view('main.page')->with([
            'title' => 'سياسة الخصوصية',
            'content' => setting('privacy')
        ]);
    }

    public function terms_and_conditions()
    {
        return view('main.page')->with([
            'title' => 'الشروط و الأحكام',
            'content' => setting('terms')
        ]);
    }

    public function about()
    {
        return view('main.page')->with([
            'title' => 'من نحن',
            'content' => setting('about')
        ]);
    }

    public function safety()
    {
        return view('main.page')->with([
            'title' => 'قواعد السلامة',
            'content' => setting('safety')
        ]);
    }

    public function advertise()
    {
        return view('main.page')->with([
            'title' => 'أعلن معنا',
            'content' => setting('advertise')
        ]);
    }

    // User in not active
    public function deactivated()
    {
        return auth()->user()->is_active() ? redirect()->route('home') : view('main.deactivated');
    }

    public function change_country($country_code){
        cookie()->queue('country', $country_code, 3*12*30*24*60);
        return redirect()->back();
    }
}
