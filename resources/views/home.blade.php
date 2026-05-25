<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $strings['common']['title'] }}</title>
  <meta name="description"
        content="{{ $strings['common']['description'] }}">
  <!-- Google Tag Manager -->
  <!--suppress EqualityComparisonWithCoercionJS -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W364CGFL');</script>
  <!-- End Google Tag Manager -->
  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="Vesper" />
  <link rel="manifest" href="/site.webmanifest" />
  <link rel="alternate" hreflang="ru" href="{{ route('home',['lang'=>'ru']) }}" />
  <link rel="alternate" hreflang="kk" href="{{ route('home',['lang'=>'kk']) }}" />
  @vite(["resources/enter/app.scss"])
  <script src="//code.jivosite.com/widget/2h3r77LUUx" async></script>
</head>
<body class="dark">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W364CGFL"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('menu')
<div id="top-wrapper" class="top-scroll container -overflow">
  <div class="_inner">
    @include('header')
    @include('address')
  </div>
</div>
<div class="container">
  @include('about')
  @include('location')
  @include('form')
  @include('points.a')
  @include('slogan')
{{--  @if($test ?? false)--}}
  @include('plans')
{{--  @endif--}}
{{--  @include('plans-static')--}}
  @include('form',['id'=>'request'])
</div>
@include('progress')
@include('alerts')
<div class="modal" id="request-modal" data-modal-close>
  <div class="_body">
    <button class="_close close-modal" data-modal-close></button>
    @include('form',['id'=>'modal-request'])
  </div>
</div>
@vite(["resources/enter/app.js"])
</body>
</html>
