<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-color: #F5F6F9">
    <div id="app">
        <nav class="bg-hite navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container mx-auto">
                {{-- <div class="flex justify-between"> --}}
                    <h1>
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
                            {{-- {{ config('app.name', 'Laravel') }} --}}
                        </a>
                    </h1>

                <div>
                    <!-- Right Side Of Navbar -->
                    <div class="flex items-center navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- <li class="nav-item"> --}}
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            {{-- </li> --}}
                            @if (Route::has('register'))
                                {{-- <li class="nav-item"> --}}
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                {{-- </li> --}}
                            @endif
                        @else
                            {{-- <li class="nav-item dropdown"> --}}
                                <theme-swithcer>
                                    
                                </theme-swithcer>

                                <dropdown align="right" width="200px">
                                    <template v-slot:trigger>
                                    <button class="nav-link dropdown-toggle" >
                                        <img 
                                        width="35"
                                        class="rounded-full mr-3"
                                        src="{{ gravatar_url(auth()->user()->email) }}" alt="">
    
                                        {{ auth()->user()->name }}
                                    </button>
                                </template>

                                <form id="logout-form" method="POST" action="{{ url('/logout') }}">
                                    @csrf

                                    <button type="submit" class="block text-default no-underline hover:underline text-sm leading-loose px-4 w-full text-left">Logout</button>

                                </form>

                                    
                                </dropdown>
                            {{-- </li> --}}
                        @endguest
                    </div>
                </div>
            {{-- </div> --}}
            </div>
        </nav>

        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
