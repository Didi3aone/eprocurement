<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                {{-- <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                    <ul aria-expanded="false" class="collapse">
                    </ul>
                </li> --}}
                <li><a href="{{ route('vendor.home') }}">Dashboard</a></li>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-truck"></i>
                        <span class="hide-menu"> {{ 'Purchase Order' }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            
                            <li>
                                <a href="{{ route('vendor.purchase-order') }}" class="">
                                    <i class="fa fas fa-caret-right"></i> 
                                    List PO
                                </a>
                            </li>
                        </li>
                    </ul>
                </li>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-clipboard"></i>
                        <span class="hide-menu"> {{ 'Bidding' }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('vendor.bidding') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                Bidding
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
        <a class="dropdown-item" href="{{ route('vendor.logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power"></i>
        </a>

        <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    <!-- End Bottom points-->
</aside>