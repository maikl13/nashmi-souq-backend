<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style>
            * {
                font-family: sans-serif;
                font-size: 18px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
            } 
            .card {
                background-color: white;
                border-radius: 6px;
                box-shadow: 0 2px 3px rgba(0,0,0,0.2);
            }
            .card-header {
                background-color: #eee;
                padding: 20px 15px;
            }
            .card-body {
                padding: 40px 15px 20px;
            }
            .wpwl-form-card {
                background-color: white;
                box-shadow: none;
                border: none;
            }
            .cancel {
                float: left;
                text-decoration: none;
                background-color: #fafafa;
                padding: 6px 20px;
                border-radius: 5px;
            }
            .clearfix {
                clear: both;
            }

            .wpwl-label-brand {display:none}
            .wpwl-control, input {
                border-radius: 0px;
                padding: 10px;
                font-size: 18px;
                height: 50px;
            }
            .input-text:focus, input[type=text]:focus, input[type=tel]:focus, input[type=url]:focus, input[type=password]:focus, input[type=search]:focus, textarea:focus {background-color: white;}
            .wpwl-brand, .wpwl-img { margin: 13px 0 0 auto;}
            .wpwl-label {
                margin-bottom: 5px;
            }
            
            .wpwl-wrapper-cardNumber {
                direction: ltr;
                text-align: right;
            }
            /* .wpwl-control-brand, .wpwl-control-brand option {font-size: 15px;} */
            @media (max-width: 360px){
                .card-header {text-align: center;}
                .card-header a {
                    display: block;
                    margin: 15px auto 0;
                    float: none;
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card" dir="rtl">
                <div class="card-header">
                    قيمة الفاتورة: {{ $amount }} ريال سعودي
                    <a href="{{ url()->previous() ?? url('/') }}" class="cancel">إلغاء</a>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <form action="{{ $return_url }}" class="paymentWidgets" data-brands="VISA MASTER">برجاء الإنتظار...</form>
                </div>
            </div>
        </div>
        <script src="/assets/plugins/jquery/js/jquery.min.js"></script>
        <script>
            var wpwlOptions = {
                locale: "ar",
                style:"card",
                brandDetection: true,
                // Use our internal BIN list to precisely detect brands
                brandDetectionType: "binlist",
                // Give priority to detected brands
                brandDetectionPriority: ["VISA","MASTER"],
                
                iframeStyles: {
                    'card-number-placeholder': {
                        'font-family': 'sans-serif',
                        'font-size': '18px',
                        'direction': 'ltr'
                    },
                    'cvv-placeholder': {
                        'font-family': 'sans-serif',
                        'font-size': '18px',
                    }
                }
                // ,
                // onReady: function() {
                    // $('select.wpwl-control-brand [value=VISA]').html('ڤيزا - Visa');  
                    // $('select.wpwl-control-brand [value=MASTER]').html('ماستر كارد - Mastercard');  
                    // $('select.wpwl-control-brand [value=MADA]').html('مدى - Mada');  
                // }
            }
        </script>
        <script src="{{ config('services.hyperpay.api_url') }}/v1/paymentWidgets.js?checkoutId={{ $checkout_id }}"></script>
    </body>
</html>

