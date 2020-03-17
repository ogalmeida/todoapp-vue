<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Vue App</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  {{-- Font awesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">

</head>

<body>
  <div id="app">
    <app class="pb-5"></app>
  </div>

  {{-- <script type="text/javascript" src="{{mix('js/app.js')}}"></script> --}}
  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>

</html>