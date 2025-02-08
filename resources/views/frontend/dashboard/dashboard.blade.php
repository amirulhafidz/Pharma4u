<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Askbootstrap">
    <meta name="author" content="Askbootstrap">
    <meta name="csrf-token" content="{{csrf_token() }}">
    
    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}">
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome-->
    <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- Font Awesome-->
    <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <!-- Select2 CSS-->
    <link href="{{ asset('frontend/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> -->

    <script src="https://js.stripe.com/v3/"></script>
    

    
</head>

<body>

    @include('frontend.dashboard.header')

    @yield('dashboard')

    @include('frontend.dashboard.footer')




    <!-- jQuery -->
    <script src="{{ asset('frontend/vendor/jquery/jquery-3.3.1.slim.min.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 JavaScript-->
    <script src="{{ asset('frontend/vendor/select2/js/select2.min.js') }}"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('frontend/vendor/owl-carousel/owl.carousel.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.iife.js"></script>
    
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>



    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- /////////////////////////----------Start JavaScript  ------- ///////////////////////////// -->
    <script type="text/javascript">
        // Create a Stripe client.
        var stripe = Stripe('pk_test_51PTSAWA7TdOaQ8J4f0g7t7sgWb9bLXFLHmHqMGF0FSlXYb8UPQgozSgeMqHpTvANsNUdbqbL0URFV8eGzC2pK9cQ00LtbB7vcF');
        // Create an instance of Elements.
        var elements = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        // Create an instance of the card Element.
        var card = elements.create('card', { style: style });
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.on('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form
            form.submit();
        }
    </script>
    <!-- /////////////////////////----------End JavaScript ------- ///////////////////////////// -->

    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif 
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })

    </script>

    <script>
        $(document).ready(function () {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });


            $('.inc').on('click', function () {
                var id = $(this).data('id');
                var input = $(this).closest('span').find('input');
                var newQuantity = parseInt(input.val()) + 1;
                updateQuantity(id, newQuantity);
            });

            $('.dec').on('click', function () {
                var id = $(this).data('id');
                var input = $(this).closest('span').find('input');
                var newQuantity = parseInt(input.val()) - 1;
                if (newQuantity >= 1) {
                    updateQuantity(id, newQuantity);
                }
            });


            $('.remove').on('click', function () {
                var id = $(this).data('id');
                removeFromCart(id);
            });

            function updateQuantity(id, quantity) {
                $.ajax({
                    url: '{{route("cart.updateQuantity")}}',
                    method: 'POST',
                    data: {
                        _token: '{{csrf_token() }}',
                        id: id,
                        quantity: quantity
                    },
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Quantity Updated'
                        }).then(() => {
                            location.reload();
                        });
                    }
                })
            }



            function removeFromCart(id) {
                $.ajax({
                    url: '{{route("cart.remove")}}',
                    method: 'POST',
                    data: {
                        _token: '{{csrf_token() }}',
                        id: id
                    },
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Quantity Removed'
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }

        })





    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!--  Apply Coupon function -->
    <script>
        function ApplyCoupon() {
            var coupon_name = $('#coupon_name').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { coupon_name: coupon_name },
                url: "/apply-coupon",
                success: function (data) {

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        });
                        location.reload();
                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message 
                }
            })
        }
    </script>

    <script>
        function couponRemove() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/remove-coupon",
                success: function (data) {
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        });
                        location.reload();

                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message 
                }
            })
        }
    </script>







</body>

</html>