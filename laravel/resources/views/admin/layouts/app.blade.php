<!DOCTYPE html>
<html lang="en">

    @section('htmlheader')
    @include('admin.layouts.partials.htmlheader')

    @show
    <body>
         <div id="App" class="App sidebar-compact-tablet -sidebar-compact-desktop">
             
            <div class="HeaderContainer">
                @section('mainheader')
                @include('admin.layouts.partials.mainheader')
            </div>
             
            <div class="SidebarContainer">
                <aside class="AppSidebar">
                    @section('sidebar')
                    @include('admin.layouts.partials.sidebar')
                </aside>                
            </div>
        
            <div class="SidebarOverlay" id="SidebarOverlay"></div>
            
            <div class="ContentContainer Dashboard">
                <div class="Content">
                    <article class="Page Dashboard">
                        <div class="PageContainer">
                            @yield('main-content')
                        </div>
                    </article>                
                </div>    
            </div>
            
            <div class="FooterContainer">
                @include('admin.layouts.partials.footer')
            </div>
        
        </div>

        @section('scripts')
        @include('admin.layouts.partials.scripts')

        @show

    </body>
</html>
