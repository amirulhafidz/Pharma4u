<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" data-key="t-menu">Menu</li>

        <li>
            <a href="index.html">
                <i data-feather="home"></i>
                <span data-key="t-dashboard">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Category</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('all.category') }}">
                        <span data-key="t-calendar">All Category</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('add.category')}}">
                        <span data-key="t-chat">Add Category</span>
                    </a>
                </li>            
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">City</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{route('all.city')}}">
                        <span data-key="t-chat">Add City</span>
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
                    <a href="{{ route('admin.all.unit') }}">
                        <span data-key="t-calendar">All Unit</span>
                    </a>
                </li>
        
                <li>
                    <a href="{{route('admin.add.unit')}}">
                        <span data-key="t-chat">Add Unit</span>
                    </a>
                </li>
            </ul>
        </li>


    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i data-feather="grid"></i>
            <span data-key="t-apps">Manage Pharmacy</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('pending.pharmacy') }}">
                    <span data-key="t-calendar">Pending Pharmacy</span>
                </a>
            </li>
    
            <li>
                <a href="{{route('approve.pharmacy')}}">
                    <span data-key="t-chat">Approve Pharmacy</span>
                </a>
            </li>
        </ul>
    </li>


    <!-- <li>
    <a href="javascript: void(0);" class="has-arrow">
        <i data-feather="grid"></i>
        <span data-key="t-apps">Manage Banner</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li>
            <a href="{{ route('all.banner') }}">
                <span data-key="t-calendar">All Banner</span>
            </a>
        </li>
    
    </ul>
    </li> -->

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i data-feather="grid"></i>
            <span data-key="t-apps">Manage Orders</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('admin.pending.order') }}">
                    <span data-key="t-calendar">Pending Orders</span>
                </a>
            </li> 
            <li>
                <a href="{{ route('admin.confirmed.order') }}">
                    <span data-key="t-calendar">Confirmed Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.processing.order') }}">
                    <span data-key="t-calendar">Processing Orders</span>
                </a>
            </li>
    
            <li>
                <a href="{{route('admin.delivered.order')}}">
                    <span data-key="t-chat">Delivered Orders</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i data-feather="briefcase"></i>
            <span data-key="t-components">Manage Reports</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
        <li>
            <a href="{{ route('admin.all.reports') }}" data-key="t-alerts">All Reports</a>
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
                <a href="{{route('admin.pending.review')}}">
                    <span data-key="t-calendar">Pending Review</span>
                </a>
            </li>
    
            <li>
                <a href="{{route('admin.approve.review')}}">
                    <span data-key="t-calendar">Approved Review</span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i data-feather="grid"></i>
            <span data-key="t-apps">Role & Permision</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{route('all.permission')}}">
                    <span data-key="t-calendar">All Permission</span>
                </a>
            </li>
    
            <li>
                <a href="{{route('add.permission')}}">
                    <span data-key="t-calendar">Add Permission</span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="{{route('adchat.index')}}">
            <i data-feather="grid"></i>
            <span data-key="t-calendar">Messages</span>
        </a>
    </li>
    </ul>

    

</div>
        <!-- Sidebar -->
    </div>
</div>