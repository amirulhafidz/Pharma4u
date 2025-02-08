@extends('frontend.dashboard.dashboard')
@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


@php
$unit = App\Models\Unit::where('client_id', $client->id)
    ->limit(3)->get();
$productName = $unit->map(function ($unit) {
    return $unit->product->product_name;
})->toArray();
$productNameString = implode('.', $productName);
$unit = App\Models\Unit::where('client_id', $client->id);
$coupon = App\Models\Coupon::where('client_id', $client->id)
    ->where('status', '1')->first();

@endphp
<title>{{$client->name}}</title>

<section class="restaurant-detailed-banner">
    <div class="text-center">
        <img class="img-fluid cover" src="{{asset('upload/client_images/' . $client->cover_photo)}}"
            style="width: 1900px; height: 424px; object-fit: cover;">
    </div>
    <div class="restaurant-detailed-header">
        <div class="container">
            <div class="row d-flex align-items-end">
                <div class="col-md-8">
                    <div class="restaurant-detailed-header-left">
                        <img class="img-fluid mr-3 float-left" alt="osahan"
                            src="{{asset('upload/client_images/' . $client->photo)}}">
                        <h2 class="text-white">{{$client->name}}</h2>
                        <p class="text-white mb-1"><i class="icofont-location-pin"></i> {{$client->address}}
                            <span class="badge badge-success">OPEN</span>
                        </p>
                        <p class="text-white mb-0"><i class="icofont-food-cart"></i>{{$productNameString}}
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="restaurant-detailed-header-right text-right">
                        <button class="btn btn-success" type="button"><i class="icofont-clock-time"></i> 25–35 min
                        </button>
                        <h6 class="text-white mb-0 restaurant-detailed-ratings"><span
                                class="generator-bg rounded text-white"><i class="icofont-star"></i> 3.1</span> 23
                            Ratings <i class="ml-3 icofont-speech-comments"></i> 91 reviews</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="offer-dedicated-nav bg-white border-top-0 shadow-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span class="restaurant-detailed-action-btn float-right">
                    <button class="btn btn-light btn-sm border-light-btn" type="button"><i
                            class="icofont-heart text-danger"></i> Mark as Favourite</button>
                    <button class="btn btn-light btn-sm border-light-btn" type="button"><i
                            class="icofont-cauli-flower text-success"></i> Seksyen 7</button>
                    <button class="btn btn-outline-danger btn-sm" type="button"><i class="icofont-sale-discount"></i>
                        OFFERS</button>
                </span>
                <ul class="nav" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill"
                            href="#pills-order-online" role="tab" aria-controls="pills-order-online"
                            aria-selected="true">Order Online</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab"
                            aria-controls="pills-gallery" aria-selected="false">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-restaurant-info-tab" data-toggle="pill"
                            href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info"
                            aria-selected="false">Pharmacy Info</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link"  href="{{ url('/message/section?senderId=1') }}" target="_blank" role="tab" aria-controls="orders" aria-selected="true"><i
                            class="icofont-food-cart"></i> Chat with pharmacist</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab"
                            aria-controls="pills-reviews" aria-selected="false">Ratings & Reviews</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="offer-dedicated-body-left">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel"
                            aria-labelledby="pills-order-online-tab">

                            @php
$popular = App\Models\Unit::where('status', 1)->where('client_id', $client->id)->where('most_popular', 1)->orderBy('id', 'desc')
    ->limit(5)->get();
                            @endphp
                            <div id="#menu" class="bg-white rounded shadow-sm p-4 mb-4 explore-outlets">
                                <h5 class="mb-4">Find Your Needs</h5>
                                <form action="{{ route('search.units') }}" method="GET" class="explore-outlets-search mb-4 rounded overflow-hidden border">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control form-control-sm border-white-btn" placeholder="Search for units..."
                                            aria-label="Search" required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icofont-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <h6 class="mb-3">Offers <span class="badge badge-success"><i class="icofont-tags"></i>
                                        15% Off All Items </span></h6>
                                <div class="owl-carousel owl-theme owl-carousel-five offers-interested-carousel mb-3">
                                    @foreach ($popular as $populars)


                                        <div class="item">
                                            <div class="mall-category-item">
                                                <a href="#">
                                                    <img class="img-fluid" src="{{ asset($populars->image) }}">
                                                    <h6>{{$populars->name}}</h6>
                                                    @if ($populars->discount_price == NULL)
                                                        RM{{$populars->price}}
                                                    @else
                                                        RM<del>{{$populars->price}}</del>
                                                        RM{{$populars->discount_price}}
                                                    @endif
                                                    <br><span class="float-right">
                                                        <a class="btn btn-outline-secondary btn-sm"
                                                            href="{{route('add_to_cart', $populars->id)}}">ADD</a>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        <div class="row">
                            <h5 class="mb-4 mt-3 col-md-12">Recommended</h5>
                            @if ($recommendedUnits->isEmpty())
                                <script>
                                    console.log('recommendedUnits empty');
                                </script>
                            @endif
                        
                            @forelse ($recommendedUnits as $unit)
                                @if ($recommendedUnits->isNotEmpty())
                                    <script>
                                        console.log("{{$unit->name}}");
                                        console.log("{{$client->name}}");
                                    </script>
                                @endif
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                        <div class="list-card-image">
                                            <a href="{{ route('viewrating', ['id' => $unit->id]) }}">
                                                <img src="{{ asset($unit->image) }}" class="img-fluid item-img">
                                            </a>
                                        </div>
                                        <div class="p-3 position-relative">
                                            <div class="list-card-body">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('viewrating', ['id' => $unit->id]) }}" class="text-black">
                                                        {{ $unit->name }}
                                                    </a>
                                                </h6>

                                                <p class="text-gray time mb-0">
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
                                                    <p>
                                                        <!-- nak ada space -->
                                                    </p>
                                                    <span class="float">
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('add_to_cart', $unit->id) }}">ADD</a>
                                                    </span>

                                                    <span class="float-right mr-1">
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('view_unit', $unit->id) }}">VIEW</a>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="col-md-12">No recommendations available at the moment.</p>
                            @endforelse
                        </div>

                @foreach ($categories as $category)
                    <!-- Check if the category has units belonging to the current pharmacy -->
                    @if ($category->units->where('client_id', $client->id)->count() > 0)
                        <div class="row">
                            <!-- Category Title -->
                            <h5 class="mb-4 mt-3 col-md-12">
                                {{ $category->category_name }}
                                <small class="h6 text-black-50">
                                    ({{ $category->units->where('client_id', $client->id)->count() }})
                                </small>
                                <!-- View All Units Link -->
                                    <a href="{{ route('view.all', ['client_id' => $client->id, 'category_id' => $category->id]) }}"
                                        class="btn btn-link ml-3">View All Units</a>

                                </h5>

                            </h5>

                            <!-- Loop Through Units Under This Category Belonging to the Pharmacy -->
                            @foreach ($category->units->where('client_id', $client->id) as $unit)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                        <div class="list-card-image">
                                            <a href="{{route('viewrating', $unit->id)}}">
                                                <img src="{{ asset($unit->image) }}" class="img-fluid item-img" alt="Unit image">
                                            </a>
                                        </div>
                                        <div class="p-3 position-relative">
                                            <div class="list-card-body">
                                                <h6 class="mb-1">
                                                    <a href="{{route('viewrating', $unit->id)}}"
                                                        class="text-black">
                                                        {{ $unit->name }}
                                                    </a>
                                                </h6>

                                                <p class="text-gray time mb-0">
                                                    <span class="badge badge-success">{{ $unit->rating }}</span>

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
                                                </p>

                                                <p>
                                                    <!-- nak ada space -->
                                                </p>
                                                    <span class="float">
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('add_to_cart', $unit->id) }}">ADD</a>
                                                    </span>

                                                    <span class="float-right mr-1">
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('view_unit', $unit->id) }}">VIEW</a>
                                                    </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach



                        </div>
                        <div class="tab-pane fade" id="pills-gallery" role="tabpanel"
                            aria-labelledby="pills-gallery-tab">
                            <div id="gallery" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="restaurant-slider-main position-relative homepage-great-deals-carousel">
                                    <div class="owl-carousel owl-theme homepage-ad">
                                        @foreach ($galleri as $index => $gallery)

                                            <div class="item">
                                                <img class="img-fluid" src="{{asset($gallery->gallery_img)}}">
                                                <div class="position-absolute restaurant-slider-pics bg-dark text-white">
                                                    {{$index + 1}} of {{$gallery->count()}}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-restaurant-info" role="tabpanel"
                            aria-labelledby="pills-restaurant-info-tab">
                            <div id="restaurant-info" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="address-map float-right ml-5">
                                    <div class="mapouter">
                                        <div class="gmap_canvas"><iframe width="300" height="170" id="gmap_canvas" 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4295.358492152027!2d101.48632271086055!3d3.0677731968950592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc52fa611ab055%3A0xca922f8ef4611a6b!2sVcare%20Pharmacy%20Seksyen%207!5e1!3m2!1sen!2sus!4v1734336025117!5m2!1sen!2sus" 
                                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                                frameborder="0" scrolling="no" marginheight="0"
                                                marginwidth="0"></iframe></div>
                                    </div>
                                </div>
                                <h5 class="mb-4">Pharmacy Info</h5>
                                <p class="mb-3">{{$client->address}}
                                </p>
                                <p class="mb-2 text-black"><i
                                        class="icofont-phone-circle text-primary mr-2"></i>{{$client->phone}}</p>
                                <p class="mb-2 text-black"><i class="icofont-email text-primary mr-2"></i>
                                    {{$client->email}}</p>
                                <p class="mb-2 text-black"><i class="icofont-clock-time text-primary mr-2"></i>
                                    {{$client->shop_info}}
                                    <span class="badge badge-success"> OPEN NOW </span>
                                </p>
                                <hr class="clearfix">
                                <p class="text-black mb-0">You can also check the 3D view by using our menue map
                                    clicking here &nbsp;&nbsp;&nbsp; <a class="text-info font-weight-bold"
                                        href="#">Venue Map</a></p>
                                <hr class="clearfix">
                                <h5 class="mt-4 mb-4">More Info</h5>
                                <p class="mb-3">Vcare</p>
                                <div class="border-btn-main mb-4">
                                    <a class="border-btn text-success mr-2" href="#"><i
                                            class="icofont-check-circled"></i> </a>
                                    <a class="border-btn text-danger mr-2" href="#"><i
                                            class="icofont-close-circled"></i> </a>
                                    <a class="border-btn text-success mr-2" href="#"><i
                                            class="icofont-check-circled"></i></a>
                                    <a class="border-btn text-success mr-2" href="#"><i
                                            class="icofont-check-circled"></i></a>
                                    <a class="border-btn text-success mr-2" href="#"><i
                                            class="icofont-check-circled"></i></a>
                                    <a class="border-btn text-danger mr-2" href="#"><i
                                            class="icofont-close-circled"></i></a>
                                    <a class="border-btn text-success mr-2" href="#"><i
                                            class="icofont-check-circled"></i></a>
                                </div>
                            </div>
                        </div>
                    <!-- Assuming you have $pharmacy passed to the view -->
                    
                        <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                            <div id="book-a-table" class="bg-white rounded shadow-sm p-4 mb-5">
                                <a class="nav-link" href="{{route('change.password')}}" role="tab" aria-controls="orders" aria-selected="true"><i
                                        class="icofont-food-cart"></i> Change Password</a>
                            </div>
                        </div>
                    


                        <div class="tab-pane fade" id="pills-reviews" role="tabpanel"
                            aria-labelledby="pills-reviews-tab">
                            <div id="ratings-and-reviews"
                                class="bg-white rounded shadow-sm p-4 mb-4 clearfix restaurant-detailed-star-rating">
                                <span class="star-rating float-right">
                                    <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                </span>
                                <h5 class="mb-0 pt-1">Rate this Place</h5>
                            </div>
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

                                <div class="graph-star-rating-body">
                                    @foreach ($ratingCounts as $star => $count)


                                        <div class="rating-list">
                                            <div class="rating-list-left text-black">
                                                {{$star}} Star
                                            </div>
                                            <div class="rating-list-center">
                                                <div class="progress">
                                                    <div style="width: {{ $ratingPercentages[$star] }}%" aria-valuemax="5" aria-valuemin="0"
                                                        aria-valuenow="5" role="progressbar"
                                                        class="progress-bar bg-primary">
                                                        <span class="sr-only">{{ $ratingPercentages[$star] }}% Complete (danger)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="rating-list-right text-black">{{ number_format($ratingPercentages[$star], 2) }}%</div>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="graph-star-rating-footer text-center mt-3 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Rate and
                                        Review</button>
                                </div>
                            </div>
                            <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
                                <a href="#" class="btn btn-outline-primary btn-sm float-right">Top Rated</a>
                                <h5 class="mb-1">All Ratings and Reviews</h5>
                                <style>
                                    .icofont-ui-rating {
                                        color:#ccc;
                                    }
                                    .icofont-ui-rating.active{
                                        color:#dd646e
                                    }

                                </style>
                                @php
$reviews = App\Models\Review::where('client_id', $client->id)->where
('status', 1)->latest()->limit(5)->get();
                                @endphp

                                @foreach ($reviews as $review)

                                <div class="reviews-members pt-4 pb-4">
                                    <div class="media">
                                    <a href="#"><img alt="Generic placeholder image" src="{{ (!empty($review->user->photo)) ?
        url('upload/user_images/' . $review->user->photo) : url('upload/no_image.jpg')}}"
                                    class="mr-3 rounded-pill"></a>
                                    <div class="media-body">
                                    <div class="reviews-members-header">
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
                                    <div class="reviews-members-body">
                                        <p>{{$review->comment}}</p>
                                    </div>
                                    <div class="reviews-members-footer">
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
                            <p><b>For Pharmacy Review, You need to Login first <a href="{{route('login')}}">
                            Login Here</a></b></p>
                            @else   
                                <style>
                                    .star-rating label {
                                        display: inline-flex;
                                        margin-right: 5px;
                                        cursor: pointer;
                                    }
                                    .star-rating input[type="radio"]:checked + .star-icon{
                                        color:#dd646e ;
                                    }
                                </style>
                                    <h5 class="mb-4">Leave Comment</h5>
                                        <p class="mb-2">Rate the Place</p>

                                        <form method="post" action="{{route('store.review')}}">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{$client->id}}">
                                        <div class="mb-4">
                                            <span class="star-rating">
                                                <label for="rating-1">
                                                <input type="radio" name="rating" id="rating-1" value="1"
                                                hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>

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
            @php
use Carbon\Carbon;
$coupon = App\Models\Coupon::where('client_id', $client->id)->where
('validity', '>=', Carbon::now()->format('Y-m-d'))->latest()->first();
            @endphp


            <div class="col-md-4">
                <div class="pb-2">
                    <div
                        class="bg-white rounded shadow-sm text-white mb-4 p-4 clearfix restaurant-detailed-earn-pts card-icon-overlap">
                        <img class="img-fluid float-left mr-3" src="{{asset('frontend/img/earn-score-icon.png')}}">
                        <h6 class="pt-0 text-primary mb-1 font-weight-bold">OFFER</h6>
                        @if ($coupon == NULL)
                            <p class="mb-0">No Coupon is available</p>
                        @else
                            <p class="mb-0">{{$coupon->discount }}% | Use coupon <span
                                    class="text-danger font-weight-bold">{{$coupon->coupon_name}}</span></p>
                        @endif

                        <div class="icon-overlap">
                            <i class="icofont-sale-discount"></i>
                        </div>
                    </div>
                </div>
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

                                                        <button class="btn btn-outline-secondary  btn-sm left dec" data-id="{{$id }}"> <i
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
                                                RM{{ $total - Session()->get('coupon')
        ['discount_amount'] }}
                                                @else
                                                    RM{{$total}}
                                                @endif

                                            </span>
                                        </p>
                                        <hr />
                                        <h6 class="font-weight-bold mb-0">Discount Amount <span class="float-right">
                                                @if (Session::has('coupon'))
                                                    RM{{Session()->get('coupon')
        ['discount_amount'] }}
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
                                                                RM{{Session()->get('coupon')
    ['discount_amount'] }}
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

                <div class="text-center pt-2 mb-4">
                    <!--  -->
                </div>
                <div class="text-center pt-2">
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


