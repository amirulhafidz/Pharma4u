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
                            <h4 class="font-weight-bold mt-0 mb-4">Order List</h4>

                            <div class="bg-white card mb-4 order-list shadow-sm">
                                <div class="gold-members p-4">
                                    <table id="" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUserOrder as $key => $item)  
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->order_date }}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>RM{{ $item->amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                            <span class="badge bg-info">Pending</span>
                                            @elseif ($item->status == 'confirm')
                                            <span class="badge bg-primary">Processing</span>
                                            @elseif ($item->status == 'process')
                                            <span class="badge bg-warning">Confirmed</span>
                                            @elseif ($item->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @endif
                                        </td>

                                        <td class = "d-flex justify-content-between">
                                            <a href="{{ route('user.order.details', $item->id) }}"
                                            class="btn-small d-block text-primary"><i
                                            class="fas fa-eye"></i>View</a>

                                            <a href="{{ route('user.invoice.download', $item->id) }}"
                                            class="btn-small d-block text-danger"><i
                                            class="fas fa-download"></i>Invoice</a>




                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>



                                </div>
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
