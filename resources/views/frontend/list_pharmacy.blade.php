@extends('frontend.dashboard.dashboard')
@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<section class="breadcrumb-osahan pt-5 pb-5 bg-dark position-relative text-center">
    <h1 class="text-white">Offers Near You</h1>
    <h6 class="text-white-50">Best deals at your favourite pharmacies</h6>
</section>


<section class="section pt-5 pb-5 products-listing">
    
    <div class="container">
        <div class="row d-none-m">
            <div class="col-md-12">
                <div class="dropdown float-right">
                <form action="{{ route('search.units') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control form-control-sm border-white-btn"
                        placeholder="Search for units..." aria-label="Search" required>
                    <button type="submit" class="btn btn-info btn-sm ml-2">Search</button>
                </form>
                </div>
                <h4 class="font-weight-bold mt-0 mb-3">OFFERS <small class="h6 mb-0 ml-2">
                    </small>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="filters shadow-sm rounded bg-white mb-4">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0">Filter By</h5>
                    </div>
                    @php
$categories = App\Models\Category::orderBy('id', 'desc')
    ->limit(10)
    ->get();
                    @endphp

                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingOne">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            Category <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">

                                    <div class="filters-card-body card-shop-filters">
                                        @foreach ($categories as $category)
                                            @php
    $categoryUnitCount = $units
        ->where('category_id', $category->id)->count();
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                id="category-{{$category->id}}" data-type="category" data-id="{{$category->id}}"> 
                                                <label class="custom-control-label" for="category-{{$category->id}}">{{$category->category_name}}<small
                                                        class="text-black-50">({{$categoryUnitCount}})</small>
                                                </label>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                                

                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                

                <div class="filters shadow-sm rounded bg-white mb-4">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0">Filter By</h5>
                    </div>
                    @php
$cities = App\Models\City::orderBy('id', 'desc')
    ->limit(10)
    ->get();
                    @endphp

                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingOnecity">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseOnecity"
                                            aria-expanded="true" aria-controls="collapseOnecity">
                                            City <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                
                                <div id="collapseOnecity" class="collapse show" aria-labelledby="headingOnecity"
                                    data-parent="#accordion">

                                    <div class="filters-card-body card-shop-filters">
                                        @foreach ($cities as $city)
                                        @php
    $cityUnitCount = $units
        ->where('city_id', $city->id)->count();
                                        @endphp
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" 
                                            id="city-{{$city->id}}" data-type="city" data-id="{{$city->id}}">
                                            <label class="custom-control-label" for="city-{{$city->id}}">{{$city->city_name}}<small
                                                    class="text-black-50">({{$cityUnitCount}})</small>
                                            </label>
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                                

                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- end div -->
                <div class="filters shadow-sm rounded bg-white mb-4">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0">Filter By</h5>
                    </div>
                    @php
$clients = App\Models\Client::orderBy('id', 'desc')
    ->limit(10)
    ->get();
                    @endphp

                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingOneproduct">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseOneproduct"
                                            aria-expanded="true" aria-controls="collapseOneproduct">
                                            Pharmacies <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                
                                <div id="collapseOneproduct" class="collapse show" aria-labelledby="headingOneproduct"
                                    data-parent="#accordion">

                                    <div class="filters-card-body card-shop-filters">
                                        @foreach ($clients as $client)
                                            @php
    $clientUnitCount = $units->where(
        'client_id',
        $client->id
    )->count();
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                id="client-{{$client->id}}" data-type="client" data-id="{{$client->id}}">
                                                <label class="custom-control-label" for="client-{{$client->id}}">{{$client->name}}<small
                                                        class="text-black-50">({{$clientUnitCount}})</small>
                                                </label>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                                

                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- end div  -->

            </div>
@php
use Carbon\Carbon;
@endphp

            <div class="col-md-9">
                
                <div class="row" id="unit-list">

                    @foreach ($units as $unit)
                                                                                                                                                        @php
                        $coupon = App\Models\Coupon::where('client_id', $unit->client_id)->where
                        ('validity', '>=', Carbon::now()->format('Y-m-d'))->latest()->first();
                                                                                                                                                        @endphp

                                                                                                                                                        @php
                        $ratingcount = App\Models\Rating::where('unit_id', $unit->id)
                            ->where('status', 1)
                            ->latest()
                            ->get();
                        $average = App\Models\Rating::where('unit_id', $unit->id)
                            ->where('status', 1)->avg('rating');
                                                            @endphp

                                                <div class="col-md-4 col-sm-6 mb-4 pb-2">
                                                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                                        <div class="list-card-image">
                                                            <div class="star position-absolute"><span class="badge badge-success"><i
                                                                        class="icofont-star"></i>{{number_format($average, 1)}}
                                                                    ({{count($ratingcount)}})+</span></div>
                                                            <div class="member-plan position-absolute">
                                                                <span class="badge badge-dark">{{$unit->client->name}}</span>
                                                            </div>

                                                            <a href="{{ route('view_unit', $unit->id) }}">
                                                                <img src="{{asset($unit->image)}}" class="img-fluid item-img">
                                                            </a>
                                                        </div>
                                                        <div class="p-3 position-relative">
                                                            <span class="float-right">
                                                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('view_unit', $unit->id) }}">VIEW</a>
                                                            </span>
                                                            <div class="list-card-body">
                                                                <h6 class="mb-1"><a href="{{route('view_unit', $unit->client_id)}}" class="text-black">{{$unit->name}}</a></h6>

                                                            <p class="text-gray mb-3 time">
                                                            <div class="item">
                                                                @if ($unit->discount_price == NULL)
                                                                    RM{{$unit->price}}
                                                                @else
                                                                    <a href="#">
                                                                        RM<del>{{$unit->price}}</del>
                                                                        RM{{$unit->discount_price}}
                                                                    </a>
                                                                @endif
                                                                <br>
                                                            </div>
                                                            </p>
                                                            </div>
                                                            <div class="list-card-badge">
                                                                <span class="badge badge-success">OFFER</span> @if ($coupon == NULL)
                                                                    <p class="mb-0">No Coupon is available</p>
                                                                @else
                                                                    <p class="mb-0">{{$coupon->discount }}% | Use coupon <span
                                                                            class="text-danger font-weight-bold">{{$coupon->coupon_name}}</span></p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


<script>
    $(document).ready(function(){
        $('.filter-checkbox').on('change',function(){
            var filters = {
                categories:[],
                cities: [],
                clients: [],
            };
            // console.log(filters);
            $('.filter-checkbox:checked').each(function(){
                var type = $(this).data('type');
                var id = $(this).data('id');

                if(!filters[type + 's']){
                    filters[type + 's']=[];
                }
                filters[type + 's'].push(id);
            });
            $.ajax({
                url: '{{ route('filter.units')}}',
                method: 'GET',
                data: filters,
                success:function(response){
                    $('#unit-list').html(response)
                }
            });

        });
    })
</script>

@endsection