<div class="p-3 mb-3 rounded text-center border border-light bg-light box-shadow">

    @if (Auth::check())
        <img class="rounded-circle mb-2 lazyload" src="{{Auth::user()->avatar}}" data-original="{{ Auth::user()->avatar }}" alt="Generic placeholder image"
             width="140" height="140">
        <h2>{{ Auth::user()->name}}</h2>
        @if ((Auth::user()->introduce) == "")
            <p>这家伙很懒，什么也没留下~~~</p>
            @else
                <p>{{ Auth::user()->introduce }}</p>
        @endif

    @else
        <img class="rounded-circle mb-2 lazyload" src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-original="{{ config('vienblog.author.avatar') }}" alt="Generic placeholder image"
             width="140" height="140">
        <h2>欢迎</h2>
        <p>这家伙很懒，什么也没留下~~~</p>
    @endif
    {{--<p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>--}}
</div>
