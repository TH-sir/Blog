<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <title>@if(isset($meta)){{ $meta['title'] }}@else Vien Blog Admin @endif</title>--}}
{{--    <meta name="description" content="@if(isset($meta)){{ $meta['description'] }}@endif">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Styles -->
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @section('css')
        <link href="{{ mix('/css/admin.css') }}" rel="stylesheet" type="text/css"/>
    @show
    @section('css_ext')
    @show
    <style>
        .ml-sm-auto, .mx-sm-auto{
            left: 10% ;
            margin-left: unset;
        }
    </style>
</head>
<body>
{{--@include('admin.layouts.header')--}}

{{--<main class="py-4">--}}
<div class="container-fluid ">
    <div class="row">
        <main role="main" class="col-md-12 ml-sm-auto col-lg-10 pt-3 px-4">
            @include('admin.layouts.alert')
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <a href="{{route('home.main.article')}}"><h3 class="h3">⇇ 文章管理</h3></a>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="submit" class="btn btn-sm btn-primary mr-1"
                            onclick="event.preventDefault();document.getElementById('new-form').submit();">
                        提交
                    </button>
                    <div class="btn-group mr-2">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('index') }}">回到首页</a>
                        {{--<button class="btn btn-sm btn-outline-secondary">Share</button>--}}
                        {{--<button class="btn btn-sm btn-outline-secondary">Export</button>--}}
                    </div>
                    {{--<button class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
                    {{--<span data-feather="calendar"></span>--}}
                    {{--This week--}}
                    {{--</button>--}}
                </div>
            </div>

            {{--<canvas class="my-4" id="myChart" width="900" height="380"></canvas>--}}
            <form action="{{ route('home.blog.article.store') }}" id="new-form" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="title">标题</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title') }}" placeholder="标题不宜太长" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                               value="{{ old('slug') }}" placeholder="拼音或者英文单词 用‘-’连接 用于URL中" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">描述</label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="{{ old('description') }}" placeholder="描述请在150字符以内 并且不要恶意堆积关键词 有利于SEO" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="keywords">关键字</label>
                        <input type="text" class="form-control" id="keywords" name="keywords"
                               value="{{ old('keywords') }}" placeholder="关键词3-5个为益 请使用英文逗号分割" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tags">标签</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                               value="{{ old('tags') }}" placeholder="标签 请使用英文逗号分割" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cate_id">分类</label>
                        <select class="form-control" id="cate_id" name="cate_id">
                            <option disabled selected>---请选择---</option>
                            @foreach($categories as $category)
                                @if($category['id'] == old('cate_id'))
                                    <option value="{{ $category['id'] }}" selected>{{ $category['cate_name'] }}</option>
                                @else
                                    <option value="{{ $category['id'] }}">{{ $category['cate_name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="new_category">或新分类</label>
                        <input type="text" class="form-control" id="new_category" name="new_category"
                               value="{{ old('new_category') }}">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="markdown">Markdown</label>
                    <textarea id="markdown" name="markdown">{!! htmlspecialchars(old('markdown')) !!}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">提交</button>
                <input type="hidden" value="Home" name="hidden"/>
            </form>
        </main>

        @section('js_ext')
            <script type="text/javascript">
                markdown_editor();
            </script>
        @endsection

    </div>
</div>
{{--</main>--}}
</body>
@section('js')
    <!-- Scripts -->
    <script src="{{ mix('js/admin.js') }}"></script>
    {{--<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>--}}
    {{--<script>--}}
    {{--feather.replace()--}}
    {{--</script>--}}
@show

@section('js_ext')
@show
</html>

