@section('title')
    <title>{!! $article['title'] !!}</title>
@show
@section('description')
    <meta name="description" content="{!! $article['description'] !!}">
@show
@section('keywords')
    <meta name="keywords" content="{!! $article['keywords'] !!}">
@show

@section('css_ext')
    <link rel="stylesheet" href="{{ asset('js/share.js/css/share.min.css') }}">
@show

<div class="col-md-8 blog-main">
    <div id="info"></div>
    <div class="border-bottom mb-3">
        <a href="#"></a>
    </div>

    <div class="blog-post mb-3">
        <h1 class="blog-post-title">{!! $article['title'] !!}</h1>

        <p class="blog-post-meta mb-0">
           <a href="{{ route('home.main.main',base64_encode($article['email'] ))}}">{{ $article['name'] }} </a> &nbsp;
            &nbsp;最后发布于{{ vn_time($article['created_at']) }} &nbsp;
            <a class="bg-gray-light"
               href="{{ route('home.blog.category.show', $article['category']['cate_name']) }}">
                &nbsp;{{ $article['category']['cate_name'] }}
            </a>
            &nbsp;<a href="javascript:void(0)" onclick="favourite({{$article['id']}});">收藏</a>
        </p>

        <p class="blog-post-meta mt-0">
            {{--            <a href="#" class="badge badge-dark">{{ $article['category']['cate_name'] }}</a>--}}
            @foreach($article['tags'] as $tag)
                <a href="{{ route('home.blog.tag.show', $tag['tag_name']) }}"
                   class="badge badge-secondary">{{ $tag['tag_name'] }}</a>
            @endforeach
        </p>
        <div class="markdown-body">
            {!! $article['markdown'] !!}
        </div>
    </div><!-- /.blog-post -->

    <script>
        function favourite (id) {
            $.ajax({
                url:'/article/favourite/' + id,
                type:'GET',
                success:function(res){
                    if (res === '1') {
                       $("#info").html('<div class="alert alert-success alert-dismissable">\n' +
                           '            <button type="button" class="close" data-dismiss="alert"\n' +
                           '                    aria-hidden="true">\n' +
                           '                &times;\n' +
                           '            </button>\n' +
                           '            收藏成功！\n' +
                           '        </div>')
                    }else{
                        $("#info").html('<div class="alert alert-warning alert-dismissable">\n' +
                            '            <button type="button" class="close" data-dismiss="alert"\n' +
                            '                    aria-hidden="true">\n' +
                            '                &times;\n' +
                            '            </button>\n' +
                            '           您已收藏，请到我的收藏查看吧\n' +
                            '        </div>')
                    }

                        },
                error:function (res) {
                    alert('收藏失败！请检查网络或稍后重试')
                }
                })
        }
    </script>
    {{--<nav class="blog-pagination">--}}
    {{--<a class="btn btn-outline-primary" href="#">Older</a>--}}
    {{--<a class="btn btn-outline-secondary" href="#">Newer</a>--}}
    {{--</nav>--}}

{{--    <div id="share" class="social-share my-4"></div>--}}
    @include('home.layouts.share')

    @include('home.blog.article.components.recommend')

</div><!-- /.blog-main -->
