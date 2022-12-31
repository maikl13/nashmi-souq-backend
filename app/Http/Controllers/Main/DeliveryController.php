<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Show Delivery request Form for the seller
    public function show()
    {
        abort(403, 'خدمة الشحن متوقفة في الوقت الحالي');

        return view('main.store.deliver');
    }

    // Send Delivery Request To Delivery Company (Nashmi) Via Whatsapp
    public function send(Request $request)
    {
        abort(403, 'خدمة الشحن متوقفة في الوقت الحالي');
        $request->validate([
            'seller_phone' => 'required|max:20',
            'seller_address' => 'required|max:300',
            'buyer_phone' => 'required|max:20',
            'buyer_address' => 'required|max:300',
            'package' => 'required|max:500',
            'amount' => 'required|integer|max:1000000',
            'details' => 'max:1500',
        ]);

        $country = auth()->user()->country;
        $phone = optional($country)->delivery_phone ? $country->delivery_phone : setting('delivery_phone');

        if (! $phone) {
            return redirect()->back()->with([
                'failure' => 'حدث خطأ ما من فضلك قم بالمحاولة في وقت لاحق',
            ]);
        }

        $this->send_whatsapp_template($phone, 'shipping', [[
            'type' => 'body',
            'parameters' => [
                ['type' => 'text', 'text' => auth()->user()->name],
                ['type' => 'text', 'text' => $request->seller_phone],
                ['type' => 'text', 'text' => $request->seller_address],
                ['type' => 'text', 'text' => $request->buyer_name],
                ['type' => 'text', 'text' => $request->buyer_phone],
                ['type' => 'text', 'text' => $request->buyer_address],
                ['type' => 'text', 'text' => $request->package],
                ['type' => 'text', 'text' => $request->amount],
                ['type' => 'text', 'text' => $request->price],
                ['type' => 'text', 'text' => $request->details],
            ],
        ]]);

        return redirect()->back()->with(['success' => 'تم ارسال الطلب بنجاح']);
    }
}
