@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    page = "{{$page}}";
</script>
<div class="container">
    <div id="pagetypes-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit pagetypes')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.have-page-pagetypes.update',$page->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Modifica</h6>
                    </div>
                    @foreach ($pagetypes as $pagetype)
                      @if($pagetype->id!=1)
                      <div>
                          @if($errors->any())
                            <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"
                            {{ in_array($pagetype->id, old('pagetypes', [])) ? 'checked=checked' : ''}}>
                          @else
                            <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"
                            {{$page->have_page_pagetypes->contains($pagetype)?'checked=checked':''}}>
                          @endif
                          <label for="pagetype-{{$pagetype->id}}" class="active">
                              {{$pagetype->name}}
                              @if($pagetype->description)
                              <div class="info">
                                  <button aria-label="{{$pagetype->description}}" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                  <i class="fas fa-info-circle"></i>
                              </div>
                              @endif
                          </label>
                      </div>
                      @endif
                    @endforeach
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
