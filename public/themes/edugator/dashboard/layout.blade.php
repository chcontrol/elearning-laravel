@include(theme('header'))

<div class="dashboard-wrap">

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-2 dashboard-menu-col">
                @include(theme('dashboard.sidebar-menu'))
            </div>

            <div class="col-10">
                @include('inc.flash_msg')
                @yield('content')
            </div>

        </div>
    </div>

</div>

@include(theme('footer'))
