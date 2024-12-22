@foreach ($filterUnits as $unit)


    <div class="col-md-4 col-sm-6 mb-4 pb-2">
        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
            <div class="list-card-image">
                <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1
                        (300+)</span></div>
                <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i
                            class="icofont-heart"></i></a></div>
                <div class="member-plan position-absolute"><span class="badge badge-dark">Prooted</span></div>
                <a href="{{route('phm.details', $unit->client_id)}}">
                    <img src="{{asset($unit->image)}}" class="img-fluid item-img">
                </a>
            </div>
            <div class="p-3 position-relative">
                <div class="list-card-body">
                    <h6 class="mb-1"><a href="{{route('phm.details', $unit->client_id)}}"
                            class="text-black">{{$unit->name}}</a></h6>

                    <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i
                                class="icofont-wall-clock"></i> 20–25 min</span> <span class="float-right text-black-50">
                            RM{{$unit->price}}</span></p>
                </div>
                <div class="list-card-badge">
                    <span class="badge badge-success">OFFER</span> <small>65% off | Use Coupon
                        OSAHAN50</small>
                </div>
            </div>
        </div>
    </div>

@endforeach