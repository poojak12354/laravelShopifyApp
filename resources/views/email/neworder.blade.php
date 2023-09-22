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
            <div style="text-align: center;">
                <h3 style="font-size: 20px; margin: 0 0 12px; color: #000;">A customer request for a quote!</h3>
                <p style="font-size: 16px; line-height: 28px; color: #000; font-weight: 400;">This email is to let you know that we’ve received a new quote request.<br>
                Please review the images uploaded by customer <a href="{{$details['folder_path']}}">here</a>.<br>
                Please contact to customer if we have any question.</p>
            </div>
            <hr>
            <h3 style="text-align:center; color: #000;">Quote summary</h3>
            <table>
                <tr><td>Quote No.: </td><td>{{$details['quote_id']}}</td></tr>
                <tr><td>First Name: </td><td>{{$details['fname']}}</td></tr>
                <tr><td>Last Name: </td><td>{{$details['lname']}}</td></tr>
                <tr><td>Email: </td><td>{{$details['email']}}</td></tr>
                <tr><td>Services: </td><td>Clipping path</td></tr>
                <tr><td>Quantity: </td><td>{{$details['image_quantity']}}</td></tr>
                <tr><td>Set margin: </td><td>{{$details['straighten']}}</td></tr>
                <tr><td>Resize image: </td><td>{{$details['resize']}}</td></tr>
                <tr><td>File Format: </td><td>{{$details['file_format']}}</td></tr>
                <tr><td>Images Folder Path: </td><td><a href="{{$details['folder_path']}}">{{$details['folder_path']}}</a></td></tr>
                <tr><td>Additional comments: </td><td>{{$details['comments']}}</td></tr>
            </table>
            <hr>
            <div style="text-align:center;">
                <h3 style="color: #000;">While you wait, you can brush up on some ecommerce and product photography tips</h3>
                <a style="text-decoration: none; color: #15c;" href="https://bigturntables.com/blogs/product-photography/photograph-large-products">How to Photograph Large Products</a><br>
                <a style="text-decoration: none; color: #15c;" href="https://bigturntables.com/blogs/product-photography/360-degree-images">Do 360 Degree Photos Increase Sales?</a><br>
                <a style="text-decoration: none; color: #15c;" href="https://bigturntables.com/collections/photography-turntables">Big Product Photography Turntables</a><br>
                <p style="color: #000;">Have questions? Simply reply to this email or send us a note at <a href="mailto:info@bigturntables.com">info@bigturntables.com</a>.</p>
            </div>
        </div>
        <div style="background-color:#000; color: #fff; text-align: center; padding: 20px 10px; margin: 20px 0 0;">Copyright © @php echo date("Y"); @endphp Big Turntables.</div>
    </div>
</body>
</html>