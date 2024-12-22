@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Unit</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                            <li class="breadcrumb-item active">Edit Unit</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">


                <div class="card">
                    <div class="card-body p-4">

                        <form id="myForm" action="{{route('admin.update.unit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$unit->id}}" >

                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Category Name</label>
                                        <select name="category_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($category as $cat)
                                                <option value="{{$cat->id}}"{{ $cat->id == $unit->category_id ? 'selected' : '' }}>{{$cat->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Product Name</label>
                                        <select name="product_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($product as $prod)
                                                <option value="{{$prod->id}}"{{ $prod->id == $unit->product_id ? 'selected' : '' }}>{{$prod->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Pharmacy Name</label>
                                        <select name="client_id" class="form-select">
                                            <option>Select</option>
                                            @foreach ($client as $clie)
                                                <option value="{{$clie->id}}" {{ $clie->id == $unit->client_id ? 'selected' : '' }}>{{$clie->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> City Name</label>
                                        <select name="city_id" class="form-select">
                                            <option>Select</option>
                                            @foreach ($city as $cit)
                                                <option value="{{$cit->id}}" {{ $cit->id == $unit->city_id ? 'selected' : '' }} >{{$cit->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Unit Name</label>
                                        <input class="form-control" type="text" name="name" id="example-text-input" value="{{$unit->name}}">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Price</label>
                                        <input class="form-control" type="text" name="price" id="example-text-input" value="{{$unit->price}}">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Discount Price</label>
                                        <input class="form-control" type="text" name="discount_price"
                                            id="example-text-input" value="{{$unit->discount_price}}">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Size/Weight/g/ml</label>
                                        <input class="form-control" type="text" name="size" id="example-text-input" value="{{$unit->size}}">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Unit Quantity</label>
                                        <input class="form-control" type="text" name="qty" id="example-text-input" value="{{$unit->qty}}">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label"> Unit Image</label>
                                        <input class="form-control" type="file" name="image" id="image">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ asset($unit->image)}}" alt=""
                                            class=" rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>
                                <!-- checkbox -->
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="most_popular" type="checkbox" id="formCheck2"
                                        value="1" {{ $unit->most_popular == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="formCheck2">
                                        Most Popular
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                        Changes</button>
                                </div>

                            </div><!-- end row -->



                        </form>
                        <!-- end card -->
                    </div>









                    <!-- end tab content -->
                </div>
                <!-- end col -->

                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },

                    product_id: {
                        required: true,
                    },


                },
                messages: {
                    name: {
                        required: 'Please Enter Unit Name',
                    },

                    product_id: {
                        required: true,
                    },




                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>


    @endsection