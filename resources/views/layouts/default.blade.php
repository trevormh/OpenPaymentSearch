<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>

    <body>
        <div role="main" class="container">

            <header class="row">
                @include('includes.header')
            </header>

            <main role="main" class="container">
                <!-- <h1 class="mt-5">Sticky footer with fixed navbar</h1>
                <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code>padding-top: 60px;</code> on the <code>body &gt; .container</code>.</p>
                <p>Back to <a href="../sticky-footer">the default sticky footer</a> minus the navbar.</p> -->

                @yield('content')
            </main>


            <footer class="row">
                @include('includes.footer')
            </footer>

        </div> <!-- closing of container -->

    </body>

</html>
