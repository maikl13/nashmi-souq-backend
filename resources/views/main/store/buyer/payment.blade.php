<html>
    <head>
        <script src="https://test-nbe.gateway.mastercard.com/checkout/version/56/checkout.js"
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
                merchant: 'EGPTEST1',
                order: {
                    amount: function() {
                        //Dynamic calculation of amount
                        return 80 + 20;
                    },
                    currency: 'EGP',
                    description: 'Ordered goods',
                    id: '{{ uniqid() }}'
                },
                interaction: {
                    operation: 'PURCHASE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.
                    merchant: {
                        name: 'NBE Test',
                        address: {
                            line1: '200 Sample St',
                            line2: '1234 Example Town'            
                        }    
                    }
                }
            });
        </script>
    </head>
    <body>
        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
    </body>
</html>