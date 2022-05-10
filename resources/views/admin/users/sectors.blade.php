@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    sectors = @json($sectors);
</script>
<div class="container">
    <div id="user-sectors">
        <div class="item-cont">
            <div class="item-style">
              <h2>Settori</h2>
              <h4 class="pb-2">Seleziona uno o più settori di appartenenza</h4>
              <form method="post" action="{{route('admin.users.storesectors',$user->id)}}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center">
                  @foreach ($sectors as $sector)
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 justify-content-center p-1">
                      <button type="button" name="button" :class="isChecked('{{$sector->id}}')?
                      'button-active-sector button-style button-color-sector w-100':
                      'button-style button-color-sector w-100'" @click="checkboxToggle('{{$sector->id}}')" id="{{$sector->id}}-b" v-cloak>
                        @if($errors->any())
                          <input type="checkbox" name="sectors[]" class="d-none" value="{{$sector->id}}" id="{{$sector->id}}"
                          {{ in_array($sector->id, old('sectors', [])) ? 'checked=checked' : ''}}>
                        @else
                          <input type="checkbox" name="sectors[]" class="d-none" value="{{$sector->id}}" id="{{$sector->id}}"
                          {{$user->sectors->contains($sector)?'checked=checked':''}}>
                        @endif
                        <span class="m-0" for="{{$sector->id}}">{{$sector->name_it}}</span>
                      </button>
                    </div>
                  @endforeach
                </div>
                <button type="submit" name="button" class="button-style button-color-blue">Salva</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
