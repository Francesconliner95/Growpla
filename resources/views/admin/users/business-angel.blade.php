@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    user = "{{$user}}";
</script>
<div class="container">
    <div id="user-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h1 class="">Business angel</h1>
                    </div>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', ['user'=> $user->id]) }}">
                  @csrf
                  @method('PUT')
                    <input type="hidden" name="name" 
                    value="{{ old('name',$user->name) }}">
                    <input type="hidden" name="surname"
                    value="{{ old('surname',$user->surname) }}">
                    @if ($user->userTypes->contains(2))
                        {{-- Money range --}}
                        <div class="sub-section">
                            <h6>{{__('Taglio d\'investimenti')}}</h6>
                            <div class="form-contrtol">
                              @foreach ($moneyranges as $moneyrange)
                                <div>
                                  <input type="radio" id="moneyrange-{{$moneyrange->id}}" name="moneyrange_id" value="{{$moneyrange->id}}"
                                  {{-- {{old('moneyrange_id',$moneyrange->id)?'checked':''}} --}}
                                  {{$moneyrange->id==$user->moneyrange_id?'checked':''}}
                                  {{!$user->moneyrange_id && $moneyrange->id==1?'checked':''}} required>
                                  <label for="moneyrange-{{$moneyrange->id}}">{{$moneyrange->range}}</label>
                                </div>
                              @endforeach
                            </div>
                            @error ('moneyrange')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        {{-- Startup Number --}}
                        <div class="sub-section">
                            <h6>Numero di startup supportate</h6>
                            <input type="number" name="startup_n" class="form-control" value="{{ old('startup_n',$user->startup_n)}}" min="0" placeholder="">
                            @error ('startup_n')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="button-style button-color">
                        {{__('Save Changes')}}
                    </button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
