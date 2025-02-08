@extends('frontend.master')
@section('content')


<section class="section pt-5 pb-5 products-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Top Pharmacies</h2>
            <p>Recommended items, based on trends</p>
            <span class="line"></span>
        </div>
        <div class="row">

            @php
                $clients = App\Models\Client::latest()->where('status', '1')->get();
            @endphp
            @foreach ($clients as $client)

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

                        @php
                            $reviewcount = App\Models\Review::where('client_id',$client->id)
                            ->where('status',1)
                            ->latest()
                            ->get();
                            $average= App\Models\Review::where('client_id',$client->id)
                            ->where('status',1)->avg('rating');
                        @endphp
                        <div class="col-md-3">

                            <div class="item pb-3">
                                <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                    <div class="list-card-image">
                                        <div class="star position-absolute"><span class="badge badge-success"><i
                                                    class="icofont-star"></i>{{number_format($average,1)}}
                                                    ({{count($reviewcount)}})+</span></div>
                                        <div class="favourite-heart text-danger position-absolute"><a aria-label="Add to wishlist"
                                                onclick="addWishList({{$client->id}})"><i class="icofont-heart"></i></a></div>
                                        

                                        <a href="{{route('phm.details', $client->id)}}">
                                            <img src="{{ asset('upload/client_images/' . $client->photo) }}"
                                                class="img-fluid item-img" style="width: 400px; height:200px;">
                                        </a>
                                    </div>
                                    <div class="p-3 position-relative">
                                        <div class="list-card-body">
                                            <h6 class="mb-1"><a href="{{route('phm.details', $client->id)}}"
                                                    class="text-black">{{$client->name}}</a></h6>
                                            <p class="text-gray mb-3">Click to view more...</p>
                                            <p class="text-gray mb-3 time"><span
                                                    class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i
                                                        class="icofont-wall-clock"></i> 10 A.M- 5.00 P.M.
                                        </div>
                                        <div class="list-card-badge">
                                            @if ($coupon)
                                                <span class="badge badge-success">OFFER</span> <small>{{$coupon->discount}} off | Use
                                                    Coupon
                                                    {{$coupon->coupon_name}}</small>

                                            @else
                                                <span class="badge badge-success">OFFER</span>
                                                <small>No Offer Available</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            @endforeach
            {{--end col md-3--}}




        </div>
    </div>
</section>

@endsection