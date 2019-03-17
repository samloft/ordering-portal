<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name', 'Online Ordering')) . ' CMS'}} - @yield('page.title')</title>

    <link href="{{ asset('css/cms/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cms/vendor/material-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <link href="{{ mix('css/cms.css') }}" rel="stylesheet">

    @yield ('styles')
</head>

<body class="layout-default">

<div class="preloader"></div>

<div class="mdk-header-layout js-mdk-header-layout">

    @include('cms.layout.header')

    <div class="mdk-header-layout__content">

        <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
            <div class="mdk-drawer-layout__content page">
                @yield('content')
            </div>

            @include('cms.layout.navigation')
        </div>
    </div>

</div>

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/cms.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cms/vendor/dom-factory.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cms/vendor/material-design-kit.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cms/vendor/dropzone.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    (function () {
        'use strict';
        // Self Initialize DOM Factory Components
        domFactory.handler.autoInit()

        // Connect button(s) to drawer(s)
        var sidebarToggle = document.querySelectorAll('[data-toggle="sidebar"]')
        sidebarToggle = Array.prototype.slice.call(sidebarToggle)

        sidebarToggle.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                var selector = e.currentTarget.getAttribute('data-target') || '#default-drawer'
                var drawer = document.querySelector(selector)
                if (drawer) {
                    drawer.mdkDrawer.toggle()
                }
            })
        })

        let drawers = document.querySelectorAll('.mdk-drawer')
        drawers = Array.prototype.slice.call(drawers)
        drawers.forEach((drawer) => {
            drawer.addEventListener('mdk-drawer-change', (e) => {
                if (!e.target.mdkDrawer) {
                    return
                }
                document.querySelector('body').classList[e.target.mdkDrawer.opened ? 'add' : 'remove']('has-drawer-opened')
                let button = document.querySelector('[data-target="#' + e.target.id + '"]')
                if (button) {
                    button.classList[e.target.mdkDrawer.opened ? 'add' : 'remove']('active')
                }
            })
        })

        // SIDEBAR COLLAPSE MENUS
        $('.sidebar .collapse').on('show.bs.collapse', function (e) {
            e.stopPropagation()
            var parent = $(this).parents('.sidebar-submenu').get(0) || $(this).parents('.sidebar-menu').get(0)
            $(parent).find('.open').find('.collapse').collapse('hide');
            $(this).closest('li').addClass('open');
        });
        $('.sidebar .collapse').on('hidden.bs.collapse', function (e) {
            e.stopPropagation()
            $(this).closest('li').removeClass('open');
        });

        // ENABLE TOOLTIPS
        $('[data-toggle="tooltip"]').tooltip()

        // PRELOADER
        window.addEventListener('load', function () {
            $('.preloader').fadeOut()
            domFactory.handler.upgradeAll()
        })

    })()
</script>

@yield('scripts')

</body>
</html>