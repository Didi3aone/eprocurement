<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                <li><a href="{{ route('vendor.home') }}">Dashboard</a></li>
                {{-- <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-truck"></i>
                        <span class="hide-menu"> {{ 'Bidding' }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('vendor.quotation-online') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List Bidding
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-truck"></i>
                        <span class="hide-menu"> Purchase Order </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('vendor.purchase-order-repeat') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List Repeat Order
                            </a> 
                        </li>
                        <li>
                            <a href="{{ route('vendor.purchase-order-direct') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List Direct Order
                            </a>
                        </li>
                    </ul>
                </li>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-clipboard"></i>
                        <span class="hide-menu"> {{ 'Billing' }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('vendor.billing') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List billing
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- end master menu --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        {{-- <a class="dropdown-item" href="{{ route('vendor.logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power"></i>
        </a> --}}

        <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    <!-- End Bottom points-->
</aside>