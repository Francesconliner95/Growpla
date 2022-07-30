@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lists = @json($lists);
</script>
<div id="list-show" class="container">
    <div class="item-cont">
        <div class="item-style">
            <h2>Messaggio</h2>
            @foreach ($lists as $key => $list)

            @endforeach
        </div>
    </div>
</div>
@endsection
