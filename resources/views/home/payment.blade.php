<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Payment for Order #{{ $order->id }}</h1>
    <p>Total: Rp{{ number_format($order->price, 0, ',', '.') }}</p>
    <form id="payment-form" action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
        @csrf
        @method("PUT")
        <button type="button" id="pay-button">Pay</button>
    </form>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // Submit the form after successful payment
                    document.getElementById('payment-form').submit();
                },
                onPending: function(result){
                    // Handle pending response if needed
                    console.log('pending result', result);
                },
                onError: function(result){
                    // Handle error response if needed
                    console.log('error result', result);
                },
                onClose: function(){
                    // Handle when customer closes the popup without completing the payment
                    alert('You closed the popup without finishing the payment');
                }
            });
        });
    </script>
</body>
</html>
