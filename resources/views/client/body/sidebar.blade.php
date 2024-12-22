@php
$id = Auth::guard('client')->id();
$client = App\Models\Client::find($id);
$status = $client->status;
@endphp



<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" data-key="t-menu">Product</li>

        <li>
            <a href="{{route('client.dashboard')}}">
                <i data-feather="home"></i>
                <span data-key="t-dashboard">Dashboard</span>
            </a>
        </li>

        @if ($status == '1')



            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Product</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('all.product')}}">
                            <span data-key="t-calendar">All Product</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('add.product')}}">
                            <span data-key="t-chat">Add Product</span>
                        </a>
                    </li>            
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Gallery</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('all.gallery')}}">
                            <span data-key="t-calendar">All Gallery</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('add.gallery')}}">
                            <span data-key="t-chat">Add Gallery</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Unit</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('all.unit')}}">
                            <span data-key="t-calendar">All Unit</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('add.unit')}}">
                            <span data-key="t-chat">Add Unit</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Coupon</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('all.coupon')}}">
                            <span data-key="t-calendar">All Coupon</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('add.coupon')}}">
                            <span data-key="t-chat">Add Coupon</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Manage Order</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('all.client.orders')}}">
                            <span data-key="t-calendar">All Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.pending.order') }}">
                            <span data-key="t-calendar">Pending Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.confirmed.order') }}">
                            <span data-key="t-calendar">Confirmed Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.processing.order') }}">
                            <span data-key="t-calendar">Processing Orders</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('client.delivered.order')}}">
                            <span data-key="t-chat">Delivered Orders</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Manage Reports</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('client.all.reports')}}">
                            <span data-key="t-calendar">All Reports</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Manage Review</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{route('client.pending.review')}}">
                            <span data-key="t-calendar">Pending Review</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('client.approve.review')}}">
                            <span data-key="t-calendar">Approved Review</span>
                        </a>
                    </li>
                </ul>
            </li>

        @else



    @endif


        

    </ul>

</div>
        <!-- Sidebar -->
    </div>
</div>