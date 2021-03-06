@extends('home.layouts.app')

@section('css_ext')
    <style>
        :root {
            --input-padding-x: .75rem;
            --input-padding-y: .75rem;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 420px;
            padding: 15px;
            margin: 0 auto;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group > input,
        .form-label-group > label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group > label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0; /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown) ~ label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }
        .mybtn{
            width:100px;
            height:30px;
            display:inline-block;
            background-color:rgb(91,183,91);
            border:1px solid rgb(91,183,91);
            border-radius:3px;
            color:white;
            font-size:14px;
            font-family:微软雅黑;
            cursor:pointer;
            text-align:center;
            vertical-align: center;
            box-shadow:0px 0px 1px 1px rgb(91,160,91);
        }
        .mybtn:hover{
            background-color:rgb(91,160,91);
            border-color:rgb(91,160,91);
            color:white;
            text-decoration:none;
        }
        .myinp{
            width:100px;
            height:30px;
            display:inline-block;
            border:1px solid rgb(209,232,250);
            border-radius:2px;
        }
        #div4bm{
            padding-top:15px;
            margin-right:15px;
        }
        #mybutton{
            margin-left:100px;
        }
        #myimg{
            width:120px;
            height:120px;
            border-radius: 50%;

        }

    </style>
@endsection

@section('content')
    <form class="form-signin" method="post" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">欢迎注册 T-Sir Blog</h1>
            <a href="{{ route('login') }}">已有账号? 直接登录</a></p>
        </div>
        <div class="form-label-group" >
            <div id="div4bm">
                <!--input[button] 触发 file click事件-->
{{--                <input type="button" value="选择文件" id="mybutton" class="mybtn" onclick="Id('file').click();" />--}}
                <!--file 隐藏起来 触发onchange事件-->
                <input type="file" name="img" accept="image/png,image/jpg,image/jpeg" id="file" onchange="changeToop();" style="display:none;" />
            </div>
            <!--图片展示区域-->
            <div style="text-align: center">
                <!--设置默认图片-->
                <img id="myimg" src="{{asset('images/avatars/相机.png')}}" onclick="Id('file').click();" name="img"/>
            </div>
        </div>
<br>
        <div class="form-label-group">
            <input type="text" id="name" name="name" class="form-control form-control-lg{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="账号"
                   value="{{ old('name') }}" required autofocus>
            <label for="name">账号</label>
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-label-group">
            <input type="email" id="email" name="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="邮箱地址"
                   value="{{ old('email') }}" required autofocus>
            <label for="email">邮箱地址</label>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="密码"
                   value="{{ old('password') }}" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <label for="password">密码</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-lg{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}" placeholder="确认密码" required>
            <label for="password-confirm">确认密码</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; {{ date('Y') }}  </p>
    </form>
    <script>
        function Id(id){
            return document.getElementById(id);
        }
        function changeToop(){
            var file = Id("file");
            if(file.value==''){
                //设置默认图片
                Id("myimg").src='{{asset('images/avatars/相机.png')}}';
            }else{
                preImg("file","myimg");
            }
        }
        //获取input[file]图片的url Important
        function getFileUrl(fileId) {
            var url;
            var file = Id(fileId);
            var agent = navigator.userAgent;
            if (agent.indexOf("MSIE")>=1) {
                url = file.value;
            } else if(agent.indexOf("Firefox")>0) {
                url = window.URL.createObjectURL(file.files.item(0));
            } else if(agent.indexOf("Chrome")>0) {
                url = window.URL.createObjectURL(file.files.item(0));
            }
            return url;
        }
        //读取图片后预览
        function preImg(fileId,imgId) {
            var imgPre =Id(imgId);
            imgPre.src = getFileUrl(fileId);
        }
    </script>
@endsection


