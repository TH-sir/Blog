@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
    <div class="alert alert-warning alert-dismissible in" role="alert">
        <strong>警告！</strong>
        {{ $error }}
        <button type="button" class="close " data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
@endif
@isset($message)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Message: </strong>
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endisset

