<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        @extends('shopify-app::layouts.default')

        @section('content')
            <p>Welcome111: {{ $shopDomain ?? Auth::user()->name }}</p>
        @endsection

        @section('scripts')
            @parent

            <script>
                var AppBridge = window['app-bridge'];
                var actions = AppBridge.actions;
                var TitleBar = actions.TitleBar;
                var Button = actions.Button;
                var Redirect = action.Redirect;
                var titleBarOptions = {
                    title: 'Welcome',
                };
                var myTitleBar = TitleBar.create(app, titleBarOptions);
            </script>
        @endsection
        <div class="">
            <?php
                $shop = Auth::user();
                $orders = $shop->api()->rest('GET','/admin/api/2022-04/orders.json');
            ?>
        </div>
    </body>
</html>
