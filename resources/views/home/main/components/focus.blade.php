@extends('home.layouts.main')

@section('content')
    <style>
        li, ul{
            padding: 0;
            margin: 0;
            list-style: none;
            font-size: 100%;
            border:0;
            vertical-align: baseline;
        }
        .content .watch_item{
            border-bottom: none;
            height: 82px;
            line-height: 82px;
            overflow: hidden;
        }
    </style>
    <p>我关注的人</p>
    <ul class="watch_item">
        <li class="content">
            <img src="" alt="">
            <a href="">文字</a>
            <a href="">取消关注</a>
        </li>
    </ul>
@endsection
