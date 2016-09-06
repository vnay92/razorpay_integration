<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <title>Checkout - Simplybook.me</title>
</head>

<body>
    <label>Enter the amount:</label>
    <input type="text" id="amount"><br>
    <button id="pay-btn">Pay</button>
</body>

<script>

    var displayMessage = function(response) {
        alert(response.message);
    };

    var handlePayment = function(response) {
        alert('Please wait while we verify the payment');
        var ajaxOptions = {
            url: '/api/payments/handle?payment_id=' + response.razorpay_payment_id,
            type:'GET',
            dataType: 'json',
        };

        var xhr = $.ajax(ajaxOptions);
        xhr.done(displayMessage);
    };

    var createOrder = function (amount, callback) {
        var ajaxOptions = {
            url: '/api/transactions',
            type:'POST',
            data: JSON.stringify({
                amount: amount
            }),
            dataType: 'json',
        };

        var xhr = $.ajax(ajaxOptions);
        xhr.done(callback);
    };

    var capturePayment = function (transactionId, paymentId, orderId, callback) {
        var ajaxOptions = {
            url: '/api/transactions/' + transactionId + '/capture',
            type:'POST',
            data: JSON.stringify({
                order_id: orderId,
                payment_id: paymentId
            }),
            dataType: 'json',
        };

        var xhr = $.ajax(ajaxOptions);
        xhr.done(callback);
    };

    var options = {
        key: "rzp_test_ECgfgVCdz6OR7w",
        name: "Integration Test",
        description: "Purchase Description",
        image: "/your_logo.png",
        handler: handlePayment,
        prefill: {
            name: '{{$data->name}}',
            email: '{{$data->email}}'
        },
    };

    $('#pay-btn').on('click', function() {
        var amount = $('#amount').val();
        if(parseInt(amount) === 0 || amount === '') {
            alert('Wrong input man!');
            return;
        }

        // Convert to paise
        options.amount = parseInt(amount) * 100;
        alert('Please wait while we initiate the payment');
        createOrder(options.amount, function(data) {
            if(data.status != 'SUCCESS') {
                alert(data.message);
                return;
            }
            options.order_id = data.order_id;
            var rzp = new Razorpay(options);
            rzp.open();

        });
    });

</script>

</html>
