<!-- Sidebar -->
<!--
          Helper classes

          Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
          Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
              If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

          Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
          Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
              - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
      -->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">N</span><span class="text-primary">T</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="index.html">
                        <i class="si si-fire text-primary"></i>
                        <span class="font-size-xl text-dual-primary-dark">NO</span><span class="font-size-xl text-primary">TARIS</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side User -->
            <div class="content-side content-side-full content-side-user px-10 align-parent">
                <!-- Visible only in mini mode -->
                <div class="sidebar-mini-visible-b align-v animated fadeIn">
                    <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                </div>
                <!-- END Visible only in mini mode -->

                <!-- Visible only in normal mode -->
                <div class="sidebar-mini-hidden-b text-center">
                    <a class="img-link" href="be_pages_generic_profile.html">
                        <img class="img-avatar" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                    </a>
                    <ul class="list-inline mt-10">
                        <li class="list-inline-item">
                            <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="#">{{ Auth::user()->nama }}</a>
                        </li>
                    </ul>
                </div>
                <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    @if(in_array(Auth::user()->role_id, [2,3]))
                        <li>
                            <a href="{{ route('dashboard') }}"><i class="si si-home"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                        </li>
                        <li>
                            <a href="{{ route('pemohon.index') }}"><i class="si si-users"></i><span class="sidebar-mini-hide">Pemohon</span></a>
                        </li>
                        <li>
                            <a href="{{ route('permohonan.index') }}"><i class="si si-docs"></i><span class="sidebar-mini-hide">Permohonan</span></a>
                        </li>
                        <li>
                            <a href="{{ route('pembayaran.index') }}"><i class="si si-wallet"></i><span class="sidebar-mini-hide">Pembayaran</span></a>
                        </li>
                    @endif
                    @if(in_array(Auth::user()->role_id, [1]))
                        <li>
                            <a href="{{ route('user.index') }}"><i class="si si-users"></i><span class="sidebar-mini-hide">User</span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->
