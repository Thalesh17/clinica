<!doctype html>
<html lang="pt-br">
    @section('htmlheader')
        @include('layouts.partials.htmlheader')
        @yield('styles-header')
        @yield('scripts-header')
    @show

<body class="hold-transition {{ getSkin() }} sidebar-mini fixed {{ getSkinPattern() }}">
        <!-- NavBar top -->
        @include('layouts.partials.mainheader')
        <!-- SideBar -->
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                @yield('header-content')
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>

        @include('layouts.partials.footer')

        @section('scripts')
            @include('layouts.partials.scripts')
            @yield('scripts-footer')
        @show

</body>
</html>