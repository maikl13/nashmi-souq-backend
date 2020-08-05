<html>
    <head>
        <script src="https://test-nbe.gateway.mastercard.com/checkout/version/57/checkout.js"
            data-error="errorCallback"
            data-cancel="cancelCallback">
        </script>

        <script type="text/javascript">
            function errorCallback(error) {
                console.log(JSON.stringify(error));
            }
            function cancelCallback() {
                console.log('Payment cancelled');
            }

            Checkout.configure({
                session: { 
                    id: '{{ $session_id }}',
                },
                billing    : {
                    address: {
                        street       : '123 Customer Street',
                        city         : 'Metropolis',
                        postcodeZip  : '99999',
                        stateProvince: 'NY',
                        country      : 'USA'
                    }
                },
                merchant: 'EGPTEST1',
                order: {
                    amount: function() {
                        //Dynamic calculation of amount
                        return {{ $amount }};
                    },
                    currency: '{{ $currency }}',
                    description: '{{ $description }}',
                    id: '{{ $uid }}'
                },
                interaction: {
                    operation: 'PURCHASE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.
                    merchant: {
                        name: '{{ config('services.mpgs.merchant') }}',
                        address: {
                            line1: '{{ $address1 }}',
                            line2: '{{ $address1 }}'            
                        }    
                    },
                    displayControl: {
                        billingAddress: 'HIDE',
                        orderSummary: 'HIDE',
                    }
                }
            });
        </script>
    </head>
    <body>
        @if(false)
            <p>{{ $successIndicator }}</p> <br>
            <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
            <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />
        @endif

        <script>
            Checkout.showPaymentPage();
        </script>
    </body>
</html>