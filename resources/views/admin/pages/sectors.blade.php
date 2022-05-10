@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    sectors = @json($sectors);
    max_sector_number = {{in_array($page->pagetype_id, array(1,2))?3:100}};
</script>
<div id="page-sectors">
        <div class="item-cont">
            <div class="item-style">
                <div class="container">
                    <h2>Settori</h2>
                    @if( in_array($page->pagetype_id, array(1,2)) )
                        <h4 class="pb-2">Seleziona fino a tre settori di appartenenza</h4>
                    @else
                        <h4 class="pb-2">Seleziona settori d'interesse</h4>
                    @endif
                </div>
              <form method="post" id="page-sectors-form" action="{{route('admin.pages.storesectors',$page->id)}}">
                @csrf
                @method('PUT')
                <div class="bg-blue pt-3 pb-3">
                    <div class="container">
                        <div class="row justify-content-center checkbox-group required">
                          @foreach ($sectors as $sector)
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 justify-content-center p-2">
                              <button type="button" name="button" :class="isChecked('{{$sector->id}}')?
                              'active multichoise-b button-style multichoise-black w-100':
                              'multichoise-b button-style multichoise-black w-100'" @click="checkboxToggle('{{$sector->id}}')" id="{{$sector->id}}-b" v-cloak>
                                @if($errors->any())
                                  <input type="checkbox" name="sectors[]" class="d-none" value="{{$sector->id}}" id="{{$sector->id}}"
                                  {{ in_array($sector->id, old('sectors', [])) ? 'checked=checked' : ''}}
                                  >
                                @else
                                  <input type="checkbox" name="sectors[]" class="d-none" value="{{$sector->id}}" id="{{$sector->id}}"
                                  {{$page->sectors->contains($sector)?'checked=checked':''}}>
                                @endif
                                <span class="m-0" for="{{$sector->id}}">{{$sector->name_it}}</span>
                              </button>
                            </div>
                          @endforeach
                        </div>
                    </div>
                </div>
                    <div class="container text-center pt-3">
                        <div v-show="display_message" class="text-center" v-cloak>
                            <span class="mini-txt txt-red font-weight-bold">@{{display_message}}</span>
                        </div>

                    </div>
                    <div class="container d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('admin.supports.switch') }}" class="font-weight-bold mini-txt txt-green">
                                Suggerisci altri settori
                            </a>
                        </div>
                        <button type="button" name="button" class="button-style button-color-green" @click="submitForm()">
                            {{$page->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
