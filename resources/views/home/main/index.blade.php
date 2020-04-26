@extends('home.layouts.main')

@section('content')

    @include('home.main.components.list')
    <script>
        $(document).ready(function () {
            $(".nav-pills li a").click(function () {
                console.log('ok')
                $.ajax({
                    url:'{{ route('home.blog.main',base64_encode(Auth::user()->email)) }}',
                    method:'GET',
                    success:function(res){
                        console.log(res['url'])
                    }
                })
            })
        })

    </script>
@endsection