<!DOCTYPE html>
<html lang="en"> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Free Guarage Management System with free technical support</title>
     <meta name="keywords" content="guarage management system,free guarage management system application,car garage management software,
    garage management software open source,
    garage management system project,
    best garage management software,
    free car garage management software,
    best garage software,
    automotive workshop management software,
    auto repair software free" />
    <meta name="description" content="Get full featured Free Guarage Management system, Best auto repair and garage management software for independent workshops and repair shop. Get top garage software features, reviews, pricing and free demo. Get free Support. "
    />
    <meta name="subject" content="Free Guarage Management System with free technical support">
    <meta name="author" content="ashutosh kumar choubey">
    <meta name="url" content="worldgyan.com">
    <meta name="identifier-URL" content="worldgyan.com">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="og:title" content="Free Guarage Management System with free technical support" />
    <meta name="og:url" content="worldgyan.com" />
    <meta name="og:image" content="public/assets/worldggyan for easy and simple.jpg" />
    <!-- logo -->
    <meta name="og:site_name" content="Free Guarage Management System with free technical support" />
    <meta name="og:description" content="Get full featured Free Guarage Management system, Best auto repair and garage management software for independent workshops and repair shop. Get top garage software features, reviews, pricing and free demo. Get free Support."
    />
    <meta property="og:type" content="Software Application" />
     <meta name="date" content="2020-01-13" scheme="YYYY-MM-DD">
  <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
  <title>{{ config('app.name') }}</title>
<script src="{{ asset('js/jQuery.min.js') }}"></script>
 

  <!-- Icons -->
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="{{ asset('css/styleOriginal.css') }}" rel="stylesheet">
  <link href="{{ asset('css/anothertemp.css') }}" rel="stylesheet"><!-- my csss  -->
  <!-- Styles required by this views -->
  <!-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}">   -->
   <!--  <link rel="stylesheet" href="{{ asset('bootstrap-4.1.3/dist/css/bootstrap.css') }}">  --> 
    <!-- Data table CSS -->
  <link href="{{ asset('js/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
   <!-- <link href="{{ asset('js/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/> -->

</head>
<!-- BODY options, add following classes to body to change options
'.header-fixed' - Fixed Header
'.brand-minimized' - Minimized brand (Only symbol)
'.sidebar-fixed' - Fixed Sidebar
'.sidebar-hidden' - Hidden Sidebar
'.sidebar-off-canvas' - Off Canvas Sidebar
'.sidebar-minimized'- Minimized Sidebar (Only icons)
'.sidebar-compact'    - Compact Sidebar
'.aside-menu-fixed' - Fixed Aside Menu
'.aside-menu-hidden'- Hidden Aside Menu
'.aside-menu-off-canvas' - Off Canvas Aside Menu
'.breadcrumb-fixed'- Fixed Breadcrumb
'.footer-fixed'- Fixed footer
-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
  @include('core.navbar')
  
  <div class="app-body">
    @include('core.sidebar')
    <!-- Main content -->
    <main class="main">

      <!-- Breadcrumb -->
      @include('core.breadcrumb')

      @yield('content')
      <!-- /.container-fluid -->
    </main>

    @include('core.asidemenu')

  </div>

  @include('core.footer')

  @include('core.scripts')
  @yield('myscript')

</body>
</html>