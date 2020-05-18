@extends('home.layouts.main')
<style>
    *{
        box-sizing: border-box;
    }
    .div{
        border: 0;
        margin: 0;
        padding: 0;
    }
    .modify{
        color: #3399ea !important;
        margin-top: 8px;
        cursor:pointer;
        padding-left: 28px
    }
    .user_info .header .head{
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin:16px auto 0;
        overflow: hidden;
        /*float: left;*/
        text-align: center;
        margin-right: 16px;
        cursor: pointer;
    }
    .right{
        width: 420px;
    }
    .info{
        margin-top: 8px;
        margin-bottom: 16px;
    }
    .line{
        height: 1px;
        background-color: #e0e0e0;
    }
    li,ul{
        padding:0;
        margin: 0;
        list-style: none;
    }
    ul{
        border:0;
        font-size: 100%;
        vertical-align: baseline;
    }
    .comon{
        height: 36px;
        line-height: 36px;
        color: #0b2e13;
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
@section('content')
<div class="user_info">
    <div class="row">
        <div class=".col-sm-3 .col-md-3 .col-lg-3 header" style="padding-left: 15px">
            <div id="img">
                <img src="{{asset(Auth::user()->avatar)}}" alt="头像加载失败" class="head" id="img">
            </div>

            <div style="margin-left: 20px;">
                <button class="modify btn" data-toggle="modal" data-target="#myModal" >修改头像</button>
            </div>
        </div>
        <div class=".col-sm-9 .col-md-9 .col-lg-9 right" style="margin: 45px 0 0 30px;">
            <div class="info">
                <span style="margin-right: 16px;color:rgb(77,77,77);">关注&nbsp;&nbsp;1</span>
                <span style="margin-right: 16px;color:rgb(77,77,77);">收藏&nbsp;&nbsp;{{$info['favourite']->count()}}</span>
            </div>
            <div class="line"></div>
           <ul class="self">
              <li class="comon">用户名：{{Auth::user()->name}}</li>
               <li class="comon">邮箱地址：{{Auth::user()->email}}</li>
               <li class="comon">简介：{{Auth::user()->introduce}}</li>
           </ul>
            <div class="line"></div>
            <div style="margin-top: 20px;">
                    <div class="form-group">
                        <input type="password" name="password" id="repass" class="form-contrl" placeholder="修改密码，请输入新密码">
                        <button type='button' class="btn btn-success" style="margin-left: 80px" onclick="repass()">修改</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<form method="post" id="mm" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        上传头像
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <div id="div4bm">
                            <!--input[button] 触发 file click事件-->
                        {{-- <input type="button" value="选择文件" id="mybutton" class="mybtn" onclick="Id('file').click();" />--}}
                        <!--file 隐藏起来 触发onchange事件-->
                            <input type="file" name="img" accept="image/png,image/jpg,image/jpeg" id="file" onchange="changeToop();" style="display:none;" />
                        </div>
                        <!--图片展示区域-->
                        <div style="text-align: center">
                            <!--设置默认图片-->
                            <img id="myimg" src="{{asset('images/avatars/相机.png')}}" onclick="Id('file').click();" name="img"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭
                    </button>
                    <button type="button" class="btn btn-primary" onclick="modify()">
                        提交更改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</form>
<script>
    function modify() {
        var formData = new FormData($( "#mm" )[0]);
        console.log(formData)
        $.ajax({
            url: '{{route('avatar.modify')}}',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (msg) {
                if(msg['code'] === 0){
                    $('#close').click();
                    location.reload();
                }
            }
        })
    }

    function repass() {
        var pass = $('#repass').val()
        console.log(pass)
        $.ajax({
            url:'{{route('password.reset')}}',
            type:'POST',
            data:{'password':pass},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function (msg) {
                if (msg['code'] === 0) {
                    $("#info").html('<div class="alert alert-success alert-dismissable">\n' +
                        '            <button type="button" class="close" data-dismiss="alert"\n' +
                        '                    aria-hidden="true">\n' +
                        '                &times;\n' +
                        '            </button>\n' +
                        '            密码修改成功，下一次记得用新密码登录哦！\n' +
                        '        </div>')
                }
            }
        })
    }

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
