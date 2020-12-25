<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SendWhatsappMessage;

class DeliveryController extends Controller
{
    use SendWhatsappMessage;

    // Show Delivery request Form for the seller
    public function show()
    {
        return view('store.seller.deliver');
    }

    // Send Delivery Request To Delivery Company (Nashmi) Via Whatsapp
    public function send(Request $request)
    {
        $request->validate([
            'seller_phone' => 'required|max:20',
            'seller_address' => 'required|max:300',
            'buyer_phone' => 'required|max:20',
            'buyer_address' => 'required|max:300',
            'package' => 'required|max:500',
            'amount' => 'required|integer|max:1000000',
            'details' => 'max:1500',
        ]);

        $phone = auth()->user()->country->delivery_phone ? auth()->user()->country->delivery_phone : setting('delivery_phone');
        if(!$phone) return redirect()->back()->with(['failure' => 'حدث خطأ ما من فضلك قم بالمحاولة في وقت لاحق']);
        $br = "
";
        $msg = 'طلب شحن جديد من سوق نشمي'.$br.$br;

        $msg .= 'البائع: '. auth()->user()->name.$br;
        $msg .= 'رقم هاتف البائع: '. $request->seller_phone.$br;
        $msg .= 'عنوان الاستلام: '. $request->seller_address.$br.$br;

        $msg .= 'اسم العميل: '. $request->buyer_name.$br;
        $msg .= 'رقم هاتف العميل: '. $request->buyer_phone.$br;
        $msg .= 'عنوان التسليم: '. $request->buyer_address.$br.$br;

        $msg .= 'نوع الشحنة: '. $request->package.$br;
        $msg .= 'الكمية: '. $request->amount.$br;
        $msg .= 'سعر الطلب: '. $request->price.$br;
        $msg .= 'بيانات إضافية: '. $request->details;

        $this->send_whatsapp_message($phone, $msg);

        return redirect()->back()->with(['success' => 'تم ارسال الطلب بنجاح']);
    }
}
