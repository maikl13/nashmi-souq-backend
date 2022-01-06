<?php

namespace App\Http\Controllers\Api;


use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Propaganistas\LaravelPhone\PhoneNumber;
use Auth;
use Str;
use Hash;
use App\Models\Listing;
use App\Models\OptionValue;
use App\Models\Brand;
use Illuminate\Auth\Events\Registered;
use App\Models\Comment;
use App\Events\NewMessage;
use App\Models\Message;
use App\Models\Conversation;

class UserController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'phoneoremail' => 'required|string',
            'password' => 'required|string'
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }

      

        $authinticated = false;
      
        
        $user = User::where('email', $request->phoneoremail)->first();
        if(Auth::attempt(['email' => $request->phoneoremail, 'password' => $request->password]) ) 
            $authinticated = true;

        if(!$authinticated){
            $user = User::where('phone', $request->phoneoremail)->first();
            if(Auth::attempt(['phone' => $request->phoneoremail, 'password' => $request->password]) ) 
                $authinticated = true;
        }

        if(!$authinticated){
            $user = $user ?? User::where('phone_national', $request->phoneoremail)->first();
            if(Auth::attempt(['phone_national' => $request->phoneoremail, 'password' => $request->password]) )
                $authinticated = true;
        }

        if(!$authinticated){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(location()->code)] ]);
            if(!$validator->fails()){
                $phone = phone($request->phoneoremail, location()->code);
                $user = $user ?? User::where('phone', $phone)->first();
                if(Auth::attempt(['phone' => $phone, 'password' => $request->password]) ) 
                    $authinticated = true;
            }
            
            else {
                return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
            }
        }

        if(!$authinticated){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(country()->code)] ]);
            if(!$validator->fails()){
                $phone = phone($request->phoneoremail, country()->code);
                $user = $user ?? User::where('phone', $phone)->first();
                if(Auth::attempt(['phone' => $phone, 'password' => $request->password]) ) $authinticated = true;
            }
            
            else {
                return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
            }
        }

         if(!$authinticated){
            if($user && $request->password == $user->otp){
                $user->password = Hash::make($user->otp);
                $user->save();
                Auth::login($user);
                $authinticated = true;
            }
             
              //return response()->json(['data'=>$user],200);
        }

        if($authinticated) {
            if(auth()->user()->otp){
               auth()->user()->otp = null;
                auth()->user()->save();
            }
             $user->api_token=Str::random(60);
             $user->save();
             Auth::login($user);
          return response()->json(['data'=>$user],200);
        }

       
       return response()->json(['data'=>'خطأ فى تسجيل الدخول بيانات خاطئة'],401);
       
    }
    
   public function register(Request $request)
    {
       
       
    }
    
    public function my_listings(){
         $listings = auth('api')->user()->listings()->latest()->paginate(15);
         return response()->json(['data'=>$listings]);
    }
    
    public function update(Request $request){
        $user =auth('api')->user();

        if(!isset($request->password) || !Hash::check($request->password, $user->password))
        return response()->json(['data'=>'كلمة المرور غير صحيحة أو لم تقم بإدخالها'],401);
        
$validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:25',
            'username' => 'required|min:2|max:25|unique:users,username,'.$user->id,
            'email' => 'nullable|email|max:255|unique:users,email,'.$user->id,
            'profile_picture' => 'image|max:8192',
            'country' => 'exists:countries,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
      

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->country_id = $request->country;

        $user->upload_profile_picture($request->file('profile_picture'));
        
       
        if($user->save()){
             return response()->json(['data'=>'تم تحديث البيانات بنجاح!'],200);
        }
        return response()->json(['data'=>'حدث خطأ حاول لاحقا'],401 );
    }
    
    public function change_password(Request $request){
        
         $user =auth('api')->user();
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8|confirmed',
            'password' => 'required',
             ]);
      
 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        if(Hash::check($request->password, $user->password)){
            $user->password = Hash::make($request->new_password);
        
            if($user->save())
               return response()->json(['data'=>'تم تحديث كلمة المرور!'],200);
            
            return response()->json(['data'=>'حدث خطأ من فضلك حاول لاحقا'],401);
            
        } else {
            return response()->json(['data'=>'كلمة المرور الحالية غير صحيحة'],401);
         
        }
    }
    
    
     public function add_listing(Request $request) {
         
         $validator = Validator::make($request->all(), [
            'listing_title' => 'required|min:10|max:255',
    		'type' => 'required|in:1,2,3,4,5,6',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,id',
    		'sub_category' => 'nullable|exists:categories,id',
            'state' => 'required|exists:states,id',
            'area' => 'nullable|exists:areas,id',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
      
    	$listing = new Listing;
        $listing->title = $request->listing_title;
        $listing->type = $request->type;
        
        if(in_array($request->type, [Listing::TYPE_SELL, Listing::TYPE_BUY, Listing::TYPE_RENT])){
            $listing->price = $request->price;
            $listing->currency_id = $request->currency;
        }

        $slug = Str::slug($request->listing_title);
        $count = Listing::where('slug', $slug)->count();
        $listing->slug = $count ? $slug.'-'.uniqid() : $slug;

    	$listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        /*$category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();*/
        $listing->address = $request->address;

        //$listing->category_id = $category->id;
        $listing->category_id = $request->category;
        //$listing->sub_category_id = $request->sub_category ? $request->sub_category : null;
        $listing->sub_category_id = $request->sub_category ? $request->sub_category : null;
        //$listing->state_id = $state->id;
        $listing->state_id = $request->state;
        //$listing->area_id = $area ? $area->id : null;
         $listing->area_id = $request->area_id ? $request->area_id : null;
        

        if(in_array($request->type, [Listing::TYPE_JOB, Listing::TYPE_JOB_REQUEST])){
            $data = [];
            if($request->age) $data['age'] = $request->age;
            if($request->gender) $data['gender'] = $request->gender;
            if($request->qualification) $data['qualification'] = $request->qualification;
            if($request->skills) $data['skills'] = $request->skills;
            $listing->data = json_encode($data);
        }
        
         $listing->brand_id = null;
        if(is_array($request->brand) && sizeof($request->brand)) {
            $brand = isset($request->brand[1]) && $request->brand[1] ? $request->brand[1] : $request->brand[0];
            $brand = Brand::where('id', $brand)->first();
            $listing->brand_id = optional($brand)->id;
        }
         
         $option_values = $request->option_values;
        if($option_values){
            array_unique($option_values);
            if (($key = array_search(null, $option_values)) !== false) unset($option_values[$key]);
            $options = [];
            foreach(OptionValue::whereIn('id', $option_values)->get() as $option_value){
                $options['options'][] = $option_value->option_id;
                $options['values'][] = $option_value->id;
            }
            $listing->options = $options;
        }

        if($listing->save()){
            if($request->has('images')){
                $listing->upload_listing_images($request->images);
            }
            return response()->json(['data'=>'تم اضافة الاعلان بنجاح'],200);
          
        }
        return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
        
     }
     
      public function destroy(Request $request,$id)
    {
        $listing=Listing::find($id);
       
        $this->authorize('delete',$listing);

        if($listing->delete()){
            return response()->json(['data'=>'تم حذف الاعلان بنجاح'],200);
            
        }
        return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
      
    }
    
     public function edit(Request $request,$id)
    {
         $listing=Listing::find($id);
        $this->authorize('edit', $listing);
        
        
         $validator = Validator::make($request->all(), [
            'listing_title' => 'required|min:10|max:255',
    		'type' => 'required|in:1,2,3,4,5,6',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,id',
    		'sub_category' => 'nullable|exists:categories,id',
            'state' => 'required|exists:states,id',
            'area' => 'nullable|exists:areas,id',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
             'brand.*' => 'nullable|exists:brands,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        
        
       

        $listing->title = $request->listing_title;
        $listing->type = $request->type;

        $listing->price = null;
        if(in_array($request->type, [Listing::TYPE_SELL, Listing::TYPE_BUY, Listing::TYPE_RENT])){
            $listing->price = $request->price;
            $listing->currency_id = $request->currency;
        }

        $slug = Str::slug($request->listing_title);
        $listing->slug = Listing::where('slug', $slug)->where('id', '!=', $listing->id)->count() ? $slug.'-'.uniqid() : $slug;

        $listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        /*$category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();*/
        $listing->address = $request->address;

        //$listing->category_id = $category->id;
        $listing->category_id = $request->category;
        //$listing->sub_category_id = $request->sub_category ? $request->sub_category : null;
        $listing->sub_category_id = $request->sub_category ? $request->sub_category : null;
        //$listing->state_id = $state->id;
        $listing->state_id = $request->state;
        //$listing->area_id = $area ? $area->id : null;
         $listing->area_id = $request->area_id ? $request->area_id : null;

        if(in_array($request->type, [Listing::TYPE_JOB, Listing::TYPE_JOB_REQUEST])){
            $data = [];
            if($request->age) $data['age'] = $request->age;
            if($request->gender) $data['gender'] = $request->gender;
            if($request->qualification) $data['qualification'] = $request->qualification;
            if($request->skills) $data['skills'] = $request->skills;
            $listing->data = json_encode($data);
        }
        
        $listing->options = [];
        $option_values = $request->option_values;
        if($option_values){
            array_unique($option_values);
            if (($key = array_search(null, $option_values)) !== false) unset($option_values[$key]);
            $options = [];
            foreach(OptionValue::whereIn('id', $option_values)->get() as $option_value){
                $options['options'][] = $option_value->option_id;
                $options['values'][] = $option_value->id;
            }
            $listing->options = $options;
        }

        $listing->brand_id = null;
        if(is_array($request->brand) && sizeof($request->brand)) {
            $brand = isset($request->brand[1]) && $request->brand[1] ? $request->brand[1] : $request->brand[0];
            $brand = Brand::where('id', $brand)->first();
            $listing->brand_id = optional($brand)->id;
        }

        if($listing->save()){
             if($request->has('images')){
                 $listing->upload_listing_images($request->images);
             }
           
           return response()->json(['data'=>'تم تعديل الاعلان بنجاح'],200);
        }
       return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
    }
    
   
    public function delete_listing_image(Request $request,$id){
          $listing=Listing::find($id);
        $this->authorize('delete', $listing);
        
         if($listing->delete_file('images', $request->key)){
              return response()->json(['data'=>'تم حذف الصورة بنجاح'],200);
         }
          return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
         
    }
    
    public function update_payout_methods(Request $request){
         $user=auth('api')->user();
        $update= $user->update([
             'bank_account'=>$request->bank_account,
             'paypal'=>$request->paypal,
             'vodafone_cash'=>$request->vodafone_cash,
             'national_id'=>$request->national_id
             ]);
             if($update){
                 return response()->json(['data'=>'تم التعديل بنجاح'],200);
             }
          return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
    }
    
    
    public function register_by_email(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
    		'password' => 'required|string|min:8|confirmed'
            
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        $uid = uniqid();

        $user_data = [];
        $user_data['name'] = 'User_'.$uid;
        $user_data['username'] = $uid;
        $user_data['email'] = $request['email'];
        $user_data['password'] = Hash::make($request['password']);
        $user = User::create($user_data);
         event(new Registered($user));
       return response()->json(['status'=>'success','data'=>$user,
        'message'=>'تم التسجيل بنجاح',
        200]);
    }
    
     public function register_by_whatsapp(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:255|unique:users|phone:AUTO,'.$request['phone_phoneCode'],
            'phone_phoneCode'=>'required'
    	
            
             ],['phone'=>'من فضلك قم بادخال رقم هاتف صحيح']);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
         $uid = uniqid();
         $user_data = [];
         
        $user_data['name'] = 'User_'.$uid;
        $user_data['username'] = $uid;
         $user_data['phone'] = phone($request['phone'], $request['phone_phoneCode'])->formatE164();
            $user_data['phone_national'] = phone($request['phone'], $request['phone_phoneCode'])->formatForMobileDialingInCountry($request['phone_phoneCode']);
            $user_data['phone_country_code'] = $request['phone_phoneCode'];
            $user_data['otp'] = rand(100100, 999000);
         $user = User::create($user_data);
        
      
            $user->send_otp();
           event(new Registered($user));
        return response()->json(['status'=>'success','data'=>$user,'message'=>'تم التسجيل بنجاح'],200) ;
     }
    
    public function add_comment(Request $request){
        
          $validator = Validator::make($request->all(), [
             'comment' => 'required',
            'listing_id' => 'nullable|exists:listings,id',
            'comment_id' => 'nullable|exists:comments,id',
            
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
       

        if(!$request->listing_id && !$request->comment_id)
            return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
            $comment = new Comment;
            $comment->body = $request->comment;
            $comment->user_id =  Auth::user()->id;
        
        if($request->comment_id){
            $parent_comment = Comment::findOrFail($request->comment_id);
            $comment->reply_on = $parent_comment->id;
            $listing = $parent_comment->commentable;
        } else {
            $listing = Listing::findOrFail($request->listing_id);
        }

        $comment->commentable_id = $listing->id;
        $comment->commentable_type = 'App\Models\Listing';

        if($comment->save()){
            
            return response()->json([
                'data'=>'تم اضافة التعليق بنجاح',
                'parent_comment_id' => isset($parent_comment) ? $parent_comment->id : null,
                'comment' => $comment
            ], 200);
        }
    }   
    
    
     public function edit_comment(Request $request,$id){
        $comment = Comment::findOrFail($id);
        $this->authorize('edit', $comment);
         $comment->body = $request->comment;
         if($comment->save()){
              return response()->json([
                'data'=>'تم تعديل التعليق بنجاح',
                  'comment'=>$comment->body
              ],200);
           
        }
        return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
         
     }    
    public function destroy_comment(Request $request,$id){
         $comment = Comment::findOrFail($id);
         $this->authorize('delete', $comment);

        if($comment->delete())
             return response()->json([
                'data'=>'تم حذف التعليق بنجاح'
              ],200);
        return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
    }
    
     public function send_message(Request $request){
          $validator = Validator::make($request->all(), [
             'message' => 'required|min:1|max:10000',
            'recipient' => 'required|exists:users,username'
            
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
     
  
        $sender = Auth::user();
        $recipient = User::where('username', $request->recipient)->first();

        if($sender->id == $recipient->id) 
           return response()->json(['data'=>' خطأ'],500);

        $conversation = Auth::user()->conversations_with( $recipient )->latest()->first();

        if($listing = Listing::find($request->listing_id)){
            if($conversation && $conversation->listing_id != $listing->id)
                $new_conversation = true;
        }
        
        if(!$conversation || isset($new_conversation)){
            $conversation = new Conversation;
            $conversation->uid = uniqid('', true);
            $conversation->sender_id = $sender->id;
            $conversation->recipient_id = $recipient->id;
            $conversation->listing_id = $listing ? $listing->id : null;
        }
        // save conversation anyway to update updated_at field 
        // to make it appear top in the latest conversations
        $conversation->save();
        
        $message = new Message;
        $message->message = $request->message;
        $message->conversation_id = $conversation->id;
        $message->sender_id = $sender->id;
        $message->recipient_id = $recipient->id;
        
        if($message->save()){
            event(new NewMessage($message));
            return response()->json([
                'data'=>'تم  ارسال الرسالة بنجاح'
              ],200);
            
        } else {
             return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'],500);
        }
    }

     public function get_conversation($user, Request $request)
        {
            $recipient = User::where('username', $user)->first();
            $conversations = Auth::user()->conversations_with( $recipient )->with('messages')->get();

            if($conversations){
                foreach($conversations as $conversation)
                    foreach ($conversation->messages()->where('recipient_id', auth()->user()->id)->unseen()->get() as $message) {
                        $message->seen = now(); // date("Y-m-d H:i:s")
                        $message->save();
                    }
                 return response()->json([
                'data'=>$conversations
              ],200);
               
            }

            return response()->json([
                'data'=>null
              ],200);
        }

    public function get_conversations()
    {       
        $conversations=Auth::user()->unique_conversations()->latest()->orderBy('updated_at', 'desc')->with('messages')->paginate(25);
          return response()->json([
                'data'=>$conversations
              ],200);
    }

    
    public function get_unseen_messages_count()
    {
          return response()->json([
                'data'=>Auth::user()->recieved_messages()->unseen()->count()
              ],200);
        
    }
    
    public function my_orders()
    {
          return response()->json([
                'data'=>Auth::user()->orders()->latest()->paginate(15)
          ],200);
        
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
    

  
    
    
    
    
    
}
