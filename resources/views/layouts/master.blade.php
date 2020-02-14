<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Portfolio">
  <meta name="author" content="Raul Santana Tilves">

  <title>Raul Santana - Portfolio</title>

  <!-- Custom fonts for this theme -->
  <link href="{{secure_asset('css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="{{secure_asset('css/app.css')}}" rel="stylesheet">

</head>

<body id="page-top">
  @include('partials.nav')

  


  @yield('content')
  
  @include('partials.footer')

  @include('partials.scripts')

</body>

</html>
