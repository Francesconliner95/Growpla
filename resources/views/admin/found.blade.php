@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="search">
    {{-- @if(!Auth::user()->user_usertype) --}}
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
              <h3 >Risultati</h3>
              <div class="">
                  <h5>Utenti</h5>
                  @foreach ($users as $user)
                      <p>{{$user->name}}</p>
                  @endforeach
                  <h5>Pagine</h5>
                  @foreach ($pages as $page)
                      <p>{{$page->name}}</p>
                  @endforeach
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
