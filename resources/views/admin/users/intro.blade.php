@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
</script>
<div id="user-intro">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h1 class="big-title m-0">POCHI, SEMPLICI STEP!</h1>
                <div class="main-cover">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6  d-flex align-items-center">
                            <div class="">
                                <div class="medium-title txt-green">
                                    <h2>1</h2>
                                    <h3>Crea il tuo profilo personale</h3>
                                </div>
                                <div class="cover bg-green-3 ">
                                    <p class="top-text">Seleziona la categoria (o le categorie) a cui appartieni.</p>
                                    <div class="row d-flex justify-content-center checkbox-group required py-4">
                                      @foreach ($userTypes as $userType)
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-2">
                                            <div class="text-center">
                                                <div>
                                                    <div class="img-cont small-img m-auto d-block">
                                                        <img src="{{asset('storage/'.$userType->image)}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center pt-2" style="height:50px">
                                                <span class="m-0 text-uppercase font-weight-bold text-white">
                                                    {{$userType->name_it}}
                                                </span>
                                            </div>
                                        </div>
                                      @endforeach
                                    </div>
                                    <p class="bottom-text">Completa gli step di registrazione inserendo informazioni relative a te ed in linea con la categoria in cui ti sei identificato/a</p>
                                </div>
                            </div>
                        </div>
                        <div class="arrow">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-center">
                            <div class="">
                                <div class="medium-title txt-blue-4">
                                    <h2>2</h2>
                                    <h3>Crea la tua pagina Business</h3>
                                </div>
                                <div class="cover bg-blue-4">
                                    {{-- <p style="color:white">Creare pagine Business relative alle tue attività</p> --}}
                                    <p class="top-text">Seleziona la tipologia di pagina</p>
                                    <div class="row d-flex justify-content-center checkbox-group required py-4">
                                      @foreach ($pageTypes as $pageType)
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-2">
                                            <div class="text-center">
                                                <div>
                                                    <div class="img-cont small-img m-auto d-block">
                                                        <img src="{{asset('storage/'.$pageType->image)}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center pt-2" style="height:50px">
                                                <span class="m-0 text-uppercase font-weight-bold text-white">
                                                    {{$pageType->name_it}}
                                                </span>
                                            </div>
                                        </div>
                                      @endforeach
                                    </div>
                                    <p class="bottom-text">Completa i diversi step inserendo informazioni relative all’attività selezionata</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <a href="{{route('admin.users.accounts',Auth::user()->id)}}"  class="font-weight-bold button-start">
                            INIZIA
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
