<!DOCTYPE html>
<html>
<head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<section>

    <form action="{{ route('payment.checkout') }}" method="POST">
        @csrf
        <button type="submit" id="checkout-button">Checkout</button>
    </form>
</section>
</body>
</html>
