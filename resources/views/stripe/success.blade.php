<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<section>

    <h3>Hello {{ $customer->name }}</h3>

    <p>Your payment was completed with success !</p>
</section>
</body>
</html>
