<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Buffalo Tools')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <link rel="stylesheet" href="{{ mix('css/fapp.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700|Teko:700|Ubuntu" rel="stylesheet">
    @yield('head')
    <meta id="csrf-token-meta"
          name="csrf-token"
          content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#4dba6f">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
@include('front.partials.navbar')
<div id="app">
    @yield('content')
</div>
<script src="{{ mix('js/front.js') }}"></script>
@yield('bodyscripts')
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','UA-51468211-9','auto');ga('send','pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<script type='application/ld+json'>
{
  "@context": "http://www.schema.org",
  "@type": "Corporation",
  "name": "Huang Buffalo",
  "url": "https://buffalo-tools.com/",
  "logo": "https://buffalo-tools.com/images/about/logo_black.png",
  "description": "Huang Buffalo Co., Ltd. has specialized in exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more than 20 years. We are proud of our wide products range, competitive prices and high quality products.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "22F-2, No. 698, Sec 4, Wenxin Road",
    "addressLocality": "Taichung City",
    "addressRegion": "Taichung",
    "postalCode": "406",
    "addressCountry": "Taiwan"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+886(042)2372753",
    "contactType": "customer service"
  }
}
 </script>
</body>
</html>