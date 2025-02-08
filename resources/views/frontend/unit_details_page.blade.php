@extends('frontend.dashboard.dashboard')

@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <section class="product-section py-5">
        <div class="container">
            <div class="mb-4">
                @if ($unit)
                    <p>Current client ID: {{  $unit->client_id }}</p>
                        <a href="{{ route('phm.details', $unit->client_id) }}" class="btn btn-outline-primary">
                            Back to Products
                        </a>
                @else
                    <p>No clients found.</p>
                @endif
            </div>
            <title>{{$unit->name}}</title>

            <div class="row">
                <div class="d-flex align-items-center cart-info h-100 rounded overflow-hidden position-relative shadow-sm">
                    <!-- Unit Image -->
                    <div class="image-container">
                        <img src="{{ asset($unit->image) }}" class="img-fluid" alt="Product Image">
                    </div>
                
                    <!-- Unit Details -->
                    <div class="unit-details ms-5 ml-2">
                        <h2>{{ $unit->name }}</h2>
                        <p class="whitespace-pre-line">
                            {!! nl2br(e($unit->description)) !!}
                        </p>
                        <div class="product-info">
                            <div class="item">
                                <a class="btn btn-link btn-sm text-black" href="#">
                                    @if ($unit->discount_price == NULL)
                                        RM{{$unit->price}}({{ $unit->size ?? '' }})
                                    @else
                                        RM<del>{{$unit->price}}</del>({{ $unit->size ?? '' }})
                                        <a href="#">
                                            RM{{$unit->discount_price}}
                                        </a>
                                    @endif
                                </a>
                                <br>
                            </div>
                            <div class="stock-info">
                                <!-- <span class="text-success">In Stock: 20</span> -->
                            </div>
                
                            <!-- Add to Cart Section -->
                            <a class="btn btn-primary add-to-cart" href="{{ route('add_to_cart', $unit->id) }}">Add to Cart</a>
                            <p></p>
                        </div>
                    </div>
                </div>




                <!-- cart -->
                <div class="col-md-4">
                    <div class="cart-info">
                        <div class="generator-bg rounded shadow-sm mb-4 p-4 osahan-cart-item">
                            <h5 class="mb-1 text-white">Your Order</h5>
                            <p class="mb-4 text-white">{{count((array) session('cart')) }}ITEMS</p>
                            <div class="bg-white rounded shadow-sm mb-2">

                                @php $total = 0 @endphp
                        @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                @php
        $total += $details['price'] * $details['quantity']
                                @endphp



                            <div class="gold-members p-2 border-bottom">
                                    <p class="text-gray mb-0 float-right ml-2">
                                        RM{{$details['price'] * $details['quantity']}}</p>
                                    <span class="count-number float-right">

                                        <button class="btn btn-outline-secondary  btn-sm left dec" data-id="{{$id}}"> <i
                                                class="icofont-minus"></i> </button>

                                        <input class="count-number-input" type="text" value="{{$details['quantity']}}"
                                            readonly="">

                                        <button class="btn btn-outline-secondary btn-sm right inc" data-id="{{$id }}">
                                            <i class="icofont-plus"></i>
                                        </button>

                                        <button class="btn btn-outline-danger btn-sm right remove" data-id="{{$id }}">
                                            <i class="icofont-trash"></i>
                                        </button>

                                    </span>
                                    <div class="media">
                                        <div class="mr-2"><img src="{{asset($details['image'])}}" alt="" width="25px"></div>
                                        <div class="media-body">
                                            <p class="mt-1 mb-0 text-black">{{$details['name']}}</p>
                                        </div>
                                    </div>
                            </div>
                            @endforeach
                        @endif

                            </div>


                            @if (Session::has('coupon'))

                            <div class="mb-2 bg-white rounded p-2 clearfix">
                                <p class="mb-1">Item Total <span
                                        class="float-right text-dark">{{count((array) session('cart'))}}</span></p>
                                <p class="mb-1">Coupon Name <span
                                        class="float-right text-dark">{{ (session()->get('coupon')['coupon_name']) }}
                                        ( {{ (session()->get('coupon')['discount']) }} %)</span>
                                    <a type="submit" onclick="couponRemove()">
                                        <i class="icofont-ui-delete float-right" style="color: red"></i></a>
                                </p>

                                <p class="mb-1 text-success">Total Discount
                                    <span class="float-right text-success">
                                        @if (Session::has('coupon'))
                                                                        RM{{ $total - Session()->get('coupon')['discount_amount'] }}
                                        @else
                                            RM{{$total}}
                                        @endif

                                    </span>
                                </p>
                                <hr />
                                <h6 class="font-weight-bold mb-0">Discount Amount <span class="float-right">
                                        @if (Session::has('coupon'))
                                                                        RM{{Session()->get('coupon')['discount_amount'] }}
                                        @else
                                            RM{{$total}}
                                        @endif
                                    </span></h6>
                            </div>

                            @else
                                <div class="mb-2 bg-white rounded p-2 clearfix">
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text" class="form-control" placeholder="Enter promo code" id="coupon_name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" id="button-addon2"
                                                onclick="ApplyCoupon()">
                                                <i class="icofont-sale-discount"></i> APPLY</button>
                                        </div>
                                    </div>
                                </div>
                            @endif





                            <div class="mb-2 bg-white rounded p-2 clearfix">
                                <img class="img-fluid float-left" src="{{asset('/frontend/img/wallet-icon.png')}}">
                                <h6 class="font-weight-bold text-right mb-2">Subtotal :
                                    <span class="text-danger">
                                        @if (Session::has('coupon'))
                                                                            RM{{Session()->get('coupon')['discount_amount'] }}
                                        @else
                                            RM{{$total}}
                                        @endif
                                    </span>
                                </h6>
                                <p class="seven-color mb-1 text-right">Extra charges may apply</p>
                            </div>




                            <a href="{{route('checkout')}}" class="btn btn-success btn-block btn-lg">Checkout <i
                                    class="icofont-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Additional Information -->

        </div>

    </section>




<!-- Shop Single Section -->
<section class="shop single section">
    <div class="container">
        

        <!-- Tabs Section -->
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ratings"
                                    role="tab">Reviews</a></li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active" id="ratings" role="tabpanel">
                            <div class="tab-single review-panel">
                            <!-- ratings-->
                                <div class="bg-white rounded shadow-sm p-4 mb-4 clearfix graph-star-rating">
                                    <h5 class="mb-0 mb-4">Ratings and Reviews</h5>
                                    <div class="graph-star-rating-header">
                                        <div class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <a href="#"><i class="icofont-ui-rating 
                                                                                {{ $i <= round($roundedAverageRating) ? 'active' : ''}}"></i></a>
                                            @endfor
                                            <b class="text-black ml-2">{{$totalReviews}}</b>
                                        </div>
                                        <p class="text-black mb-4 mt-2">Rated {{$roundedAverageRating}} out of 5</p>
                                    </div>
                                
                                
                                    <div class="graph-star-rating-footer text-center mt-3 mb-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm">Rate and
                                            Review</button>
                                    </div>
                                </div>
                                <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-ratings">
                                    <a href="#" class="btn btn-outline-primary btn-sm float-right">Top Rated</a>
                                    <h5 class="mb-1">All Ratings and Reviews</h5>
                                    <style>
                                        .icofont-ui-rating {
                                            color: #ccc;
                                        }
                                
                                        .icofont-ui-rating.active {
                                            color: #dd646e
                                        }
                                    </style>
                                    @php
$ratings = App\Models\Rating::where('unit_id', $unit->id)->where
('status', 1)->latest()->limit(5)->get();
                                                                    @endphp
                                
                                    @foreach ($ratings as $review)
                                <div class="ratings-members pt-4 pb-4">
                                    <div class="media">
                                        <a href="#"><img alt="Generic placeholder image"
                                                src="{{ (!empty($review->user->photo)) ?
        url('upload/user_images/' . $review->user->photo) : url('upload/no_image.jpg')}}"
                                                class="mr-3 rounded-pill" style="width: 50px; height: 50px; object-fit: cover;"></a>
                                        <div class="media-body">
                                            <div class="ratings-members-header">
                                                <span class="star-rating float-right">

                                        @php
    $rating = $review->rating ?? 0;
                                        @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating)
                                                            <a href="#"><i class="icofont-ui-rating active"></i></a>
                                                        @else
                                                            <a href="#"><i class="icofont-ui-rating"></i></a>
                                                        @endif
                                                    @endfor
                                                </span>
                                                <h6 class="mb-1"><a class="text-black" href="#">{{$review->user->name}}</a></h6>
                                                <p class="text-gray">{{Carbon\Carbon::parse
    ($review->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                            <div class="ratings-members-body">
                                                <p>{{$review->comment}}</p>
                                            </div>
                                            <div class="ratings-members-footer">
                                                <a class="total-like" href="#"><i class="icofont-thumbs-up"></i> 88K</a>
                                                <a class="total-like" href="#"><i class="icofont-thumbs-down"></i>
                                                    1K</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    @endforeach
                                
                                    <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#">See All Reviews</a>
                                </div>
                                <div class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                                    @guest
                                        <p class="text-center p-5">You need to Login first to leave a review <br>
                                        <a href="{{ route('leave.rating', $unit->id) }}" class="btn btn-success btn-block btn-lg">Login</a>
                                        OR
                                        <a style="color:blue" href="{{route('register')}}">Register</a></p>
                                    @else
                                        <style>
                                            .star-rating label {
                                                display: inline-flex;
                                                margin-right: 5px;
                                                cursor: pointer;
                                            }

                                            .star-rating input[type="radio"]:checked+.star-icon {
                                                color: #dd646e;
                                            }
                                        </style>
                                        <h5 class="mb-4">Leave Comment</h5>
                                        <p class="mb-2">Rate the Place</p>

                                        <form method="post" action="{{route('store.rating')}}">
                                            @csrf
                                            <input type="hidden" name="unit_id" value="{{$unit->id}}">
                                            <input type="hidden" name="client_id" value="{{ $unit->client_id }}">
                                            <div class="mb-4">
                                                <span class="star-rating">
                                                    <label for="rating-1">
                                                        <input type="radio" name="rating" id="rating-1" value="1" hidden><i
                                                            class="icofont-ui-rating icofont-2x star-icon"></i></label>

                                                    <label for="rating-2">
                                                        <input type="radio" name="rating" id="rating-2" value="2" hidden><i
                                                            class="icofont-ui-rating icofont-2x star-icon"></i></label>

                                                    <label for="rating-3">
                                                        <input type="radio" name="rating" id="rating-3" value="3" hidden><i
                                                            class="icofont-ui-rating icofont-2x star-icon"></i></label>

                                                    <label for="rating-4">
                                                        <input type="radio" name="rating" id="rating-4" value="4" hidden><i
                                                            class="icofont-ui-rating icofont-2x star-icon"></i></label>

                                                    <label for="rating-5">
                                                        <input type="radio" name="rating" id="rating-5" value="5" hidden><i
                                                            class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <label>Your Comment</label>
                                                <textarea class="form-control" name="comment" id="comment"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-sm" type="submit"> Submit Comment </button>
                                            </div>
                                        </form>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</section>
>

<style>
    .product-section {
        background-color: #f8f9fa;
        display: flex;
        flex-wrap: wrap; /* Allow wrapping for smaller screens */
        gap: 20px; /* Add spacing between elements */
    }

    .product-section h2 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #333;
    }

    .product-section .price {
        font-size: 1.5rem;
        margin-top: 10px;
    }

    .product-section .new-price {
        color: #d9534f;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .product-section .old-price {
        text-decoration: line-through;
        color: #999;
        margin-left: 10px;
    }

    .product-section .offer-timer {
        margin-top: 20px;
        background-color: #f1f1f1;
        padding: 10px;
        border-radius: 5px;
    }

    .product-section .offer-timer p {
        margin-bottom: 10px;
    }

    .product-section .quantity-section {
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    .product-section .quantity-input {
        width: 50px;
        text-align: center;
    }

    .product-section .add-to-cart {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 1.2rem;
        background-color: #28a745;
        color: white;
    }

    .product-section .shipping-info,
    .product-section .returns-info {
        background-color: #fff;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .product-section .shipping-info p,
    .product-section .returns-info p {
        font-size: 1rem;
        color: #333;
    }
</style>

<style>
    /* Optional custom styles */
    .cart-info {
    display: flex; /* Flexbox for side-by-side layout */
    align-items: center; /* Vertically align content */
    background-color: #fff;
    flex: 1; /* Take available space proportionally */
    display: flex;
    align-items: flex-start;
    gap: 20px; /* Add space between image and details */
}



.image-container {
    flex-shrink: 0; /* Prevent the image from shrinking */
    max-width: 100%; /* Adjust this percentage to control image size */
}

.image-container img {
    width: 100%; /* Ensure the image scales properly */
    height: auto; /* Maintain aspect ratio */
}

.unit-details {
    flex-grow: 1; /* Allow the details section to take up remaining space */
    padding-right: 10px;
    padding-left: 30px;
}

.unit-details h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.unit-details .product-info .price {
    font-size: 1.2rem;
    margin-top: 10px;
}


.unit-details .btn {
    margin-top: 15px;
    
}

    /* Ensure the layout looks good on smaller screens */
    @media (max-width: 768px) {
        .cart-info {
            width: 100%;
            margin-top: 20px;
            /* Adds space above cart */
        }
    }
</style>

@endsection