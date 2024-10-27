<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            @if( View::hasSection('sub_title') )
                @yield('sub_title') - {{ config('app.name') }}
            @elseif( View::hasSection('title') )
                @yield('title')
            @else
                {{ config('app.name') }}
            @endif
        </title>

        @vite(['resources/css/app.css'])
    </head>
    <body>
        <div class="p-3">
            {{ $slot }}
        </div>
        @vite(['resources/js/app.js'])
        @yield('script')
    </body>
</html>
