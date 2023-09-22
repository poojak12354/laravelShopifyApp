<!DOCTYPE html>
<html>
<head>
    <title>Bigturntables</title>
</head>
<body>
<div style="background-color:#ffffff; max-width: 600px; border: 1px solid #eee; margin: 0 auto;">
    <div style="text-align:center; padding: 20px 16px 14px; background: #000; border-radius: 10px 10px 0 0px !important;">
            <img style="text-align: center;" src="https://cdn.shopify.com/s/files/1/0600/4503/3700/files/bigturn-logo-white_240x.png?v=1646112213">
    </div>
    <div style="padding:10px;">
        <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">Your quote #Q{{ $details['quote_id'] }} is now ready. Please see the details of your quote below:</p>
        <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">Services: Clipping path<br>Quantity: {{ $details['image_count'] }}<br>Total: {{ $details['amount_payable'] }} {{ $details['currency'] }}</p>
        <a style="font-size: 16px; line-height: 28px; font-weight: 400; text-decoration: none; color: #000;" href="{!! nl2br($details['link']) !!}">View Quote Details</a>
        <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">If the above link is not clickable, please copy below link to process your payment</p>
        <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">{!! nl2br($details['link']) !!}</p>
        <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">Questions, comments, concerns about your quote? View your quote now to view more details, or reply to this email
        to get in touch.</p>
    </div>
    <div style="background-color:#000; color: #fff; text-align: center; padding: 20px 10px; margin: 20px 0 0;">Copyright © @php echo date("Y"); @endphp Big Turntables.</div>
</div>
</body>
</html>