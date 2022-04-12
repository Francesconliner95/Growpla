@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="page-create">
        <div class="item-cont">
            <div class="item-style">
                <h2>Nome {{$pagetype->name_it}}</h2>
              <form method="post" action="{{route('admin.pages.store')}}">
                @csrf
                <div class="pb-3">
                  <input type="hidden" name="pagetype_id" value="{{$pagetype->id}}">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" minlength="3" maxlength="30" autocomplete="name" required>
                  @error('name')
                      <span class="alert alert-danger">
                          {{__($message)}}
                      </span>
                  @enderror
                </div>
                <button type="submit" name="button" class="button-style button-color-blue">Salva</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
