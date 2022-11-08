<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{config("app.name")}}</title>

    <!--
    <link href="{{ asset('css/editor.css') }}" rel="stylesheet" />
    -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/popup.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />
    <link href="{{ asset('css/common.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />
    <link href="{{ asset('css/mypage.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />
    <link href="{{ asset('css/etc.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />

    <!-- 네이버 검색등록 -->
    <meta name="naver-site-verification" content="" />
    <meta name="description" content="">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{config("app.name")}}">
    <meta property="og:description" content="">
    <meta property="og:url" content="{{config("app.url")}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{"app.name"}}">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta name="twitter:card" content="">
    <meta name="twitter:title" content="{{config("app.name")}}">
    <meta name="twitter:description" content="">
    <meta name="twitter:domain" content="{{config("app.name")}}">

    <!-- 카카오 주소찾기 -->
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

    <script src="{{ asset('js/jquery.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/newspaper.js') }}" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- 아임포트 -->
    <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

    <!-- 카카오톡 -->
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' https//www.khan.co.kr/*">

    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>
@inertia
</body>
</html>
