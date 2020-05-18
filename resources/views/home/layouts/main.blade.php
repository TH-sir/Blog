<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>个人中心</title>
    @section('css')
        <link href="{{ mix('/css/web.css') }}" rel="stylesheet" type="text/css"/>
    @show
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{ mix('js/web.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <style>
        .nav-scroller{
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.05);
        }
        .col-md-2{
            padding: 15px;
        }
        .col-md-10{
            padding: 15px;
        }
        .z1{
            color: #6c757d ;
        }
        .border-bottom{
            border-bottom:0px solid #e5e5e5
        }
    </style>
</head>
<body>

<main role="main" class="container">
    <div id="info"></div>
    <div class="row">
        @include('home.layouts.header')
       <div class="container" style="padding-top: 15px;">
           <div class="row">
                <div class="col-md-2 column ui-sortable border" id="app">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{route('home.main.focus')}}" class="nav-link z1">我关注的人</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('home.main.favourites')}}" class="nav-link z1">我的收藏</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('home.main.article') }}" class="nav-link z1">我的博客</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link z1">草稿箱</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="nav-item">
                               <a href="{{route('home.main.main',base64_encode(Auth::user()->email))}}" class="nav-link active z1">个人中心</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link z1">账号设置</a>
                        </li>
                       <div class="dropdown-divider"></div>
                       <li class="nav-item">
                           <a href="#" class="nav-link z1">帮助</a>
                       </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link z1">退出</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10 column ui-sortable border" id="app">
                    @yield('content')
                </div>
        </div>
        </div>
    </div>
</main>


</body>
<script>
   $('.nav-pills').on("click","a",function(){
       $(".nav-pills li a").removeClass("active");
       $(this).addClass("active");
   });
   $(".nav-pills li a").each(function(){
        if($(this).attr('href') === window.location.href){
            console.log(this.href)
           $(".nav-pills li a").removeClass("active");
           $(this).addClass("active");
       }
   })


  //console.log(window.location.href)
</script>
</html>
