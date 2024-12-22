@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">



<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Reports</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row ">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                                <div>
                                    <h5 class="font-size-13 mb-3">.</h5>
                                    <div class="">
                                        <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <form id="myForm" action="{{route('admin.search.bydate') }}" method="post" enctype="multipart/form-data">
                                @csrf
                    
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <h4>Searcy By Date</h4>
                                            <div class="form-group mb-3">
                                                <label for="example-text-input" class="form-label"> Date</label>
                                                <input class="form-control" type="date" name="date" id="example-text-input">
                                            </div>
                    
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                                                    Date</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <div class="col-sm-4">
                    <div class="card">
                        <form id="myForm" action="{{route('admin.search.bymonth') }}" method="post" enctype="multipart/form-data">
                            @csrf
                
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <h4>Searcy By Month</h4>
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Month</label>
                                            <select name="month" class="form-select">
                                                <option selected>Select Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>

                                            <label for="example-text-input" class="form-label">Year</label>
                                            <select name="year" class="form-select">
                                                <option selected>Select Year</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2025">2026</option>
                                            </select>
                                        </div>
                
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                                                Date</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="card">
                        <form id="myForm" action="{{route('admin.search.byYear') }}" method="post" enctype="multipart/form-data">
                            @csrf
                
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <h4>Searcy By Month</h4>
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Year</label>
                                            <select name="year" class="form-select">
                                                <option selected>Select Year</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2025">2026</option>
                                            </select>
                                        </div>
                
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                                                Date</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div> <!-- end col -->



        </div> <!-- end row -->


    </div> <!-- container-fluid -->
</div>


@endsection