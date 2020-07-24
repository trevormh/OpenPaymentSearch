<!doctype html>
<html>
        @include('includes.head')

    <body>
        <div role="main" class="container">

            <header class="row">
                @include('includes.header')
            </header>

            <main role="main" class="container">
                
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                @yield('content')
            </main>
        </div> <!-- closing of container -->

        <footer>
            @include('includes.footer')
        </footer>

    </body>

</html>
