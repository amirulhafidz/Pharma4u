@extends('client.client_dashboard')
@section('client')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">



<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Orders</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
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
                                @foreach ($orderItemGroupData as $key => $orderItem)  
                                    @php
                                        $firstItem = $orderItem->first();
                                        $order = $firstItem->order;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>{{ $order->invoice_no }}</td>
                                        <td>RM{{ $order->amount }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                            <span class="badge bg-info">Pending</span>
                                            @elseif ($order->status == 'confirm')
                                            <span class="badge bg-primary">Processing</span>
                                            @elseif ($order->status == 'process')
                                            <span class="badge bg-warning">Confirmed</span>
                                            @elseif ($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @endif
                                        </td>

                                        <td><a href="{{ route('client.order_details', $order->id) }}"
                                        class="btn btn-info waves-effect waves-light"><i
                                        class="fas fa-eye"></i></a>


                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>


@endsection