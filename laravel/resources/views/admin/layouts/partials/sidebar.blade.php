<header class="SidebarHeader">
    <a class="LogoLink" href="{{ url('/home') }}">
        <div class="Logo">
            <title>logo</title>
            <img src="{{ asset('assets/img/admin_logo.png') }}" class="img-responsive">
        </div>
    </a>
    <h2 class="Title">
        <a class="Link" href="/">
            <span>TestAssignmentPHP</span>
        </a>
    </h2>
</header>

<div class="SidebarContent">
    <nav class="SidebarNav" id="SidebarNav">
        
        <a href="{{ url('/admin') }}" class="NavLink {{ Request::is('admin/dashboard') || Request::is('admin') ? '-active' : '' }}">
            <i class="icon-home NavIcon"></i>
            <span> {{ __('Dashboard') }} </span>
        </a>
                        
    </nav>
</div>

<footer id="SidebarFooter" class="SidebarFooter">
    <nav class="SidebarFooterNav">

                
    </nav>
</footer>