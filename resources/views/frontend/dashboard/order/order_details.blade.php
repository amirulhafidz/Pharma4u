@extends('frontend.dashboard.dashboard')
@section('dashboard')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


@php
$id = Auth::user()->id;
$profileData = App\Models\User::find($id);

@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
        <div class="row">

            @include('frontend.dashboard.sidebar')

            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <h4 class="font-weight-bold mt-0 mb-4">Order Details</h4>

                            
                                            <div class="row row-cols-1 row-col-md-1 row-cols-lg-2 row-cols-xl-2">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Shipping Details</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered border-primary mb-0">
                                            
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="50%">Shipping Name</th>
                                                                            <td>{{ $order->name }}</td>
                                                                        </tr>
                                            
                                            
                                                                        <tr>
                                                                            <th width="50%">Shipping Phone</th>
                                                                            <td>{{ $order->phone }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Shipping Email</th>
                                                                            <td>{{ $order->email }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Shipping Address</th>
                                                                            <td>{{ $order->address }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Order Date</th>
                                                                            <td>{{ $order->order_date }}</td>
                                                                        </tr>
                                            
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                            
                                            
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            
                                                <!-- order details -->
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Order Details <br>
                                                                <span class="text-danger">Invoice:{{ $order->invoice_no }}</span>
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered border-primary mb-0">
                                            
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="50%">Shipping Name</th>
                                                                            <td>{{ $order->user->name }}</td>
                                                                        </tr>
                                            
                                            
                                                                        <tr>
                                                                            <th width="50%">Shipping Phone</th>
                                                                            <td>{{ $order->user->phone }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Shipping Email</th>
                                                                            <td>{{ $order->user->email }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Payment Method</th>
                                                                            <td>{{ $order->payment_method }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Transaction ID</th>
                                                                            <td>{{ $order->transaction_id }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Invoice</th>
                                                                            <td class="text-danger">{{ $order->invoice_no }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Order Amount</th>
                                                                            <td>RM{{ $order->amount }}</td>
                                                                        </tr>
                                            
                                                                        <tr>
                                                                            <th width="50%">Order Status</th>
                                                                            <td><span class="badge bg-success">{{ $order->status }}</span>
                                                                            </td>
                                                                        </tr>
                                            
                                            
                                            
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                            
                                            
                                                        </div>
                                                    </div>
                                                </div> <!-- end col order details -->
                                            
                                            </div> <!-- end row -->
                                            
                                            <div class="row row-cols-1 row-col-md-1 row-cols-lg-2 row-cols-xl-1">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="col-md-1">
                                                                            <label>Image</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Unit Name</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Pharmacy Name</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Unit Code</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Quantity</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Price</label>
                                                                        </td>
                                                                        <td class="col-md-1">
                                                                            <label>Amount</label>
                                                                        </td>
                                                                    </tr>
                                                                    @foreach ($orderItem as $item)
                                                                        <tr>
                                                                            <td class="col-md-1">
                                                                                <label>
                                                                                    <img src="{{asset($item->unit->image)}}" style="width:50px; height:50px">
                                                                                </label>
                                                                            </td>
                                                                            <td class="col-md-2">
                                                                                <label>
                                                                                    {{$item->unit->name}}
                                                                                </label>
                                                                            </td>
                                                                            @if ($item->client_id == NULL)
                                                                                <td class="col-md-1">
                                                                                    <label>
                                                                                        owner
                                                                                    </label>
                                                                                </td>
                                                                            @else
                                                                                <td class="col-md-2">
                                                                                    <label>
                                                                                        {{$item->unit->client->name}}
                                                                                    </label>
                                                                                </td>

                                                                            @endif
                                                                            <td class="col-md-2">
                                                                                <label>
                                                                                    {{$item->unit->code}}
                                                                                </label>
                                                                            </td>
                                                                            <td class="col-md-2">
                                                                                <label>
                                                                                    {{$item->qty}}
                                                                                </label>
                                                                            </td>
                                                                            <td class="col-md-2">
                                                                                <label>
                                                                                    {{$item->price}}
                                                                                </label>
                                                                            </td>
                                                                            <td class="col-md-2">
                                                                                <label>
                                                                                    RM{{$item->price * $item->qty }}
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <h4>Total Amount: RM{{$totalPrice}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            </div> <!-- container-fluid -->
                                            </div>



                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




@endsection
