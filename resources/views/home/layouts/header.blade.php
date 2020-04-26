<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand pl-2" href="/">{{ config('vienblog.blog.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <a href="https://vienblog.com"></a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">首页<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.blog.link.friend') }}">友情链接</a>
                    </li>
                </ul>
                {{--<form class="form-inline mt-2 mt-md-0">--}}
                {{--<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">--}}
                {{--<button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>--}}
                {{--</form>--}}
                @guest()
                    <a class="btn btn-sm btn-outline-light btn-border-circle mr-2 my-2" href="{{ route('login') }}">登录</a>
                    <a class="btn btn-sm btn-outline-light btn-border-circle my-2" href="{{ route('register') }}">注册</a>
                @else
                    <div class="btn-group">
                        <a class="btn btn-sm btn-outline-light btn-border-circle mr-2 my-2 active dropdown-toggle"
                           data-toggle="dropdown" href="#">Hi, {{ Auth::user()->name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">我关注的人</a>
                            <a class="dropdown-item" href="#">我的收藏</a>
                            <a class="dropdown-item" href="{{route('home.blog.console')}}">我的博客</a>
                            <a class="dropdown-item" href="#">草稿箱</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('home.blog.main',base64_encode(Auth::user()->email))}}">个人中心</a>
                            <a class="dropdown-item" href="#">账号设置</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">帮助</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >退出</a>
                        </div>
                    </div>
                    <a class="btn btn-sm btn-outline-light btn-border-circle my-2" href="{{url('/blog/new')}}" style="margin-left: 10px">创建新博客</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <div class="nav-scroller mb-2">
        <nav class="nav d-flex justify-content-between">
            @foreach(config('vienblog.header.links') as $link)
                <a class="p-2 text-muted" href="{{ $link['url'] }}">{{ $link['title'] }}</a>
            @endforeach
        </nav>
    </div>
</div>
<script>
    $(".btn-group").mouseover(function () {
        $('.dropdown-menu').show();
    });
    //鼠标移开样式
    $(".btn-group").mouseout(function () {
        $('.dropdown-menu').hide();
    });
</script>