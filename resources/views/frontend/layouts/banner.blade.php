


        <section class="pt-5 pb-5 homepage-search-block position-relative">
            <div class="banner-overlay"></div>
            <div class="container">
                <div class="row d-flex align-items-center py-lg-4">
                    <div class="col-lg-8 mx-auto">
                        <div class="homepage-search-title text-center">
                            <h1 class="mb-2 display-4 text-shadow text-white font-weight-normal" style="font-family: 'Poppins', sans-serif;"><span
                                    class="font-weight-bold">Pharmacy at Your Convenience
                                </span></h1>
                            <h5 class="mb-5 text-shadow text-white-50 font-weight-normal">Lists of Pharmacies</h5>
                        </div>
                        <div class="homepage-search-form">
                            <form action="{{ route('search.units') }}" method="GET" class="explore-outlets-search mb-4 rounded overflow-hidden border">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control form-control-sm border-white-btn" placeholder="Search anything..."
                                            aria-label="Search" required>
                                            
                                        <button type="submit" class="btn btn-primary">
                                            Search
                                        </button>
                                    </div>
                                </form>
                                                    </div>
                        <h6 class="mt-4 text-shadow text-white font-weight-normal">E.g. Supplement, Vitamin, Healthcare,
                            Skincare..</h6>
                        <div class="owl-carousel owl-carousel-category owl-theme">
                        @php
$units = App\Models\Unit::latest()->limit(8)->get();
                        @endphp    

                        @foreach ($units as $unit)


                            <div class="item">
                                    <div class="osahan-category-item">
                                        <a href="{{route('view_unit', $unit->id)}}">
                                            <img class="img-fluid" src="{{ asset($unit->image) }}" alt="">
                                            <h6>{{Str::limit($unit->name, 8)}}</h6>
                                            <p>RM{{$unit->price}}</p>
                                        </a>
                                    </div>
                                </div>
                        @endforeach    
                        </div>
                    </div>
        
                </div>
            </div>
        </section>