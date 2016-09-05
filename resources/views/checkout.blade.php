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
    var options = {
        key: "rzp_test_ECgfgVCdz6OR7w",
        name: "Integration Test",
        description: "Purchase Description",
        image: "/your_logo.png",
        handler: 'handlePayment',
        prefill: {
            name: '{{$data->name}}',
            email: '{{$data->email}}'
        },
        notes: {
            address: "Hello World"
        },
    };

    var handlePayment = function(response) {
        console.log(response);
        alert(response.razorpay_payment_id);
    };

    var createOrder = function (amount, callback) {

    };

    $('#pay-btn').on('click', function() {
        var amount = $('#amount').val();
        if(parseInt(amount) === 0 || amount === '') {
            alert('Wrong input man!');
            return;
        }
        // Convert to paise
        options.amount = parseInt(amount) * 100;
        createOrder(amount, function(data) {

        });
        var rzp = new Razorpay(options);
        rzp.open();
    });

</script>

</html>
