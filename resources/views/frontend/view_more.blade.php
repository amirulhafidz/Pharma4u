@extends('frontend.dashboard.dashboard')

@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@php
$client = App\Models\Client::find($client);
$coupon = App\Models\Coupon::where('client_id', $client->id)
    ->where('status', '1')->first();
    
@endphp

<section class="breadcrumb-osahan pt-5 pb-5 bg-dark position-relative text-center">
    <h1 class="text-white">Offers Near You</h1>
    <h6 class="text-white-50">Best deals at your favourite pharmacies</h6>
</section>


<section class="section pt-5 pb-5 products-listing">
    <div class="container">
        <div class="row d-none-m">
            <div class="col-md-12">
                <h4 class="font-weight-bold mt-0 mb-3">OFFERS <small class="h6 mb-0 ml-2">{{ $units->count() }}
                        products</small></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="filters shadow-sm rounded bg-white mb-4">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0">Filter By</h5>
                    </div>

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
    $categoryUnitCount = $units->where('category_id', $category->id)->count();
    $isChecked = in_array($category->id, $selectedCategories ?? []); // Check if category is selected
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox"
                                                    id="category-{{$category->id}}" data-type="category"
                                                    data-id="{{$category->id}}" {{ $isChecked ? 'checked' : '' }}>
                                                <!-- Add the 'checked' attribute -->
                                                <label class="custom-control-label" for="category-{{$category->id}}">
                                                    {{$category->category_name}}<small
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

                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingOneproduct">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse"
                                            data-target="#collapseOneproduct" aria-expanded="true"
                                            aria-controls="collapseOneproduct">
                                            Products <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>

                                <div id="collapseOneproduct" class="collapse show" aria-labelledby="headingOneproduct"
                                    data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">
                                        @foreach ($products as $product)
                                            @php
    $productUnitCount = $units->where('product_id', $product->id)->count();
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox"
                                                    id="product-{{$product->id}}" data-type="product"
                                                    data-id="{{$product->id}}">
                                                <label class="custom-control-label"
                                                    for="product-{{$product->id}}">{{$product->product_name}}<small
                                                        class="text-black-50">({{$productUnitCount}})</small>
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
            </div>
            @php
use Carbon\Carbon;
$coupon = App\Models\Coupon::where('client_id', $client->id)->where
('validity', '>=', Carbon::now()->format('Y-m-d'))->latest()->first();
            @endphp

            

            <div class="col-md-9">
                <div class="row">

                    @forelse ($recommendedUnits as $unit)
                                                                                                    @php
                        $ratingcount = App\Models\Rating::where('unit_id', $unit->id)
                            ->where('status', 1)
                            ->latest()
                            ->get();
                        $average = App\Models\Rating::where('unit_id', $unit->id)
                            ->where('status', 1)->avg('rating');
                                                                                                    @endphp

                                                                                                        <div class="col-md-4 col-sm-6 mb-4 pb-2">
                                                                                                            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-lg">
                                                                                                                <div class="list-card-image">

                                                                                                                    <div class="star position-absolute"><span class="badge badge-success"><i
                                                                                                                                    class="icofont-star"></i>{{number_format($average, 1)}}
                                                                                                                                    ({{count($ratingcount)}})+</span></div>
                                                                                                                    <div class="favourite-heart text-danger position-absolute">
                                                                                                                        <a href="detail.html"><i class="icofont-heart"></i></a>
                                                                                                                    </div>
                                                                                                                    <div class="member-plan position-absolute">
                                                                                                                        <span class="badge badge-dark">Recommended</span>
                                                                                                                    </div>
                                                                                                                    <a href="{{ route('view_unit', ['id' => $unit->id]) }}">
                                                                                                                        <img src="{{ asset($unit->image) }}" class="img-fluid item-img">
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
                                                                                                                        <span class="badge badge-success">OFFER</span>  @if ($coupon == NULL)
                                                                                                                            <p class="mb-0">No Coupon is available</p>
                                                                                                                        @else
                                                                                                                            <p class="mb-0">{{$coupon->discount }}% | Use coupon <span
                                                                                                                                    class="text-danger font-weight-bold">{{$coupon->coupon_name}}</span></p>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                    @empty
                                                                                    <p class="col-md-12">No recommendations available at the moment.</p>
                                                                                @endforelse
                                                                            </div>




                                                                    <div class="row" id="unit-list">
                                                                        <!-- <h5 class="mb-4 mt-3 col-md-12">Products</h5> -->
                                                                        @foreach ($unitsSelect as $unit)
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
                                                                                                                                                        <span class="badge badge-dark">{{$client->name}}</span>
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
                                                                                                                                                        <span class="badge badge-success">OFFER</span>  @if ($coupon == NULL)
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
</section>
<script>
    $(document).ready(function () {
        var client = @json($client); // Assuming $clientId contains the pharmacy/client ID
        $('.filter-checkbox').on('change', function () {
            var filters = {
                categories: [],
                products: [],
                client_id: client // Pass the pharmacy ID to the request
            };

            // Collect selected filters
            $('.filter-checkbox:checked').each(function () {
                var type = $(this).data('type'); // This should be 'category' or 'product'
                var id = $(this).data('id'); // The ID of the selected category or product

                if (type === 'category') {
                    filters.categories.push(id);
                } else if (type === 'product') {
                    filters.products.push(id);
                }
            });

            // Send AJAX request with filters
            $.ajax({
                url: '{{ route('filter.select') }}',
                method: 'GET',
                data: filters,
                success: function (response) {
                    $('#unit-list').html(response); // Update the unit list dynamically
                },
                error: function (xhr, status, error) {
                    console.error('Error occurred:', error);
                }
            });
        });
    });
</script>



@endsection