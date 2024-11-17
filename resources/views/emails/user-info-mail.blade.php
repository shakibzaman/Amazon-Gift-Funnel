<!DOCTYPE html>
<html>

<head>
    <title>Optin User Info</title>
</head>

<body>
    <h1>Optin User Info</h1>
    <p>User Name : {{ $userInfo['user_name'] }}</p>
    <p>User Email: {{ $userInfo['user_email'] }}</p>
    <p>User Phone: {{ $userInfo['user_phone'] }}</p>
    <p>User Address: {{ $userInfo['user_address'] }}</p>
    <p>Product Purchased Date: {{ $userInfo['product_date_of_purchased'] }}</p>
    <p>Name or retailer Purchased From: {{ $userInfo['product_purchased_from'] }}</p>
    <p>Product Purchased: {{ $userInfo['purchased_product'] }}</p>
    <p>Form Submitted on: https://gift.audienhearing.com/optin</p>
</body>

</html>