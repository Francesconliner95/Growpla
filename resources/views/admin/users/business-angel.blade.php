@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    user = @json($user);
</script>
<div id="user-edit" style="background-image: url({{asset("storage/images/bg-servizi.svg") }}); background-position: right -200px bottom 100px; background-repeat: no-repeat; background-attachment: fixed; background-size: 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <div class="header mb-3">
                    {{-- Nome --}}
                    <div class="d-flex align-items-center">
                        <div class="img-cont mini-img mr-3">
                            <img src="{{asset('storage/users_images/default-business-angel.svg')}}" alt="">
                        </div>
                        <h1 class="m-0">Business angel</h1>
                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', ['user'=> $user->id]) }}">
                  @csrf
                  @method('PUT')
                    <input type="hidden" name="name"
                    value="{{ old('name',$user->name) }}">
                    <input type="hidden" name="surname"
                    value="{{ old('surname',$user->surname) }}">
                    <input type="hidden" name="summary"
                    value="{{ old('summary',$user->summary) }}">
                    <div class="row">
                        @if ($user->userTypes->contains(2))
                            {{-- Money range --}}
                        <div class="gray-cont col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="">
                                <h6>Taglio d'investimenti
                                    <div class="info">
                                        <button aria-label="Entità dell'investimento che effettui sulla singola startup" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                </h6>
                                <div class="form-contrtol">
                                  @foreach ($moneyranges as $moneyrange)
                                    <div class="d-flex align-items-center mr-2 mb-1">
                                        <label class="input-container m-0">
                                            {{$moneyrange->range}}
                                            <input type="radio" id="moneyrange-{{$moneyrange->id}}" name="moneyrange_id" value="{{$moneyrange->id}}"
                                            {{$moneyrange->id==$user->moneyrange_id?'checked':''}}
                                            {{!$user->moneyrange_id && $moneyrange->id==1?'checked':''}}
                                            required>
                                            <span class="checkmark mt-1"></span>
                                        </label>
                                    </div>
                                    {{-- <div>
                                      <input type="radio" id="moneyrange-{{$moneyrange->id}}" name="moneyrange_id" value="{{$moneyrange->id}}"
                                      {{$moneyrange->id==$user->moneyrange_id?'checked':''}}
                                      {{!$user->moneyrange_id && $moneyrange->id==1?'checked':''}} required>
                                      <label for="moneyrange-{{$moneyrange->id}}">{{$moneyrange->range}}</label>
                                    </div> --}}
                                  @endforeach
                                </div>
                                @error ('moneyrange')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            {{-- Startup Number --}}
                            <div class="pt-2">
                                <h6>Numero di startup supportate
                                    <div class="info">
                                        <button aria-label="Numero di startup nella quale hai investito" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                </h6>
                                <input type="number" name="startup_n" class="form-control custom-input-blue col-sm-12 col-md-6 col-lg-6 col-xl-6" value="{{ old('startup_n',$user->startup_n)}}" min="0" placeholder="">
                                @error ('startup_n')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        {{-- <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-center">
                            <button type="submit" class="button-style button-color">
                                {{$user->tutorial?'Avanti':'Salva'}}
                            </button>
                        </div> --}}
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <div class="">
                        </div>
                        <button type="submit" class="button-style button-color">
                            {{$user->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
