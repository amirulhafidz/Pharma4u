<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- <script src="https://cdn.jsdelivr.net/npm/laravel-echo@^1.11.0/dist/echo.iife.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.17.1/dist/echo.iife.js"></script>
        


        <!-- Styles -->

        <script>
     window.onload = function() {
         // Check if Echo is available
        window.Echo.channel('testChannel')
             .subscribed(() => {
                 console.log('Successfully subscribed to testChannel');
             })
             .listen('ChatMessageSent', (event) => {
                 console.log('Received message:', event.message); // Log the message here
             });


         // Now that Echo is loaded, subscribe to the channel
        setTimeout(() => {
             window.Echo.channel('testChannel')
                .listen('ChatMessageSent', (event) => {
                    console.log('Message received:', e); // Log the entire event to check the structure
                    console.log('Message content:', e.message); // Access message if it’s in e.message
                });

         }, 200);
     };
</script>

     
    </head>
    <body>
        @vite('resources/js/app.js')

     
    </body>






</html>
