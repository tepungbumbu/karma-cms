<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Nexus CMS Installer</title>
    <!-- CSS files -->
    <link href="{{ asset('vendor/tabler/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <h1 class="text-primary">NEXUS CMS</h1>
          </a>
        </div>
        
        <div class="card card-md">
          <div class="card-body">
            @yield('content')
          </div>
        </div>

        <div class="text-center text-secondary mt-3">
          &copy; {{ date('Y') }} Karma-CMS Core Architecture
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('vendor/tabler/js/tabler.min.js') }}" defer></script>
    @stack('scripts')
  </body>
</html>
