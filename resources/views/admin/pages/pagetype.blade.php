@extends('layouts.app')

@section('content')
<script type="text/javascript">
    pagetypes = @json($pagetypes);
</script>

<div id="page-pagetype" {{--style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left 0px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size:cover;"--}}>
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 class="font-weight-bold">Crea pagina business</h3>
                <div class="pt-2">
                    <h6 class="pb-2">Growpla ti permette di associare al tuo profilo personale delle pagine connesse alle attività che possiedi o per le quali operi.
                    </h6>
                    <h6 class="">Seleziona il tipo di pagina che intendi creare</h6>
                    <div class="row d-flex justify-content-center checkbox-group required py-4">
                      @foreach ($pagetypes as $pagetype)
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-5">
                            <div class="text-center">
                                <a href="{{route('admin.pages.newPage', $pagetype->id)}}" class="d-inline-block scale">
                                    <div class="img-cont small-img m-auto d-block">
                                        <img src="{{asset('storage/'.$pagetype->image)}}" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="text-center pt-2">
                                <span class="m-0 text-uppercase font-weight-bold text-dark mini-txt">
                                    {{$pagetype->name_it}}
                                    @if($pagetype->description_it)
                                    <button type="button" class="tooltip-custom cursor-default" data-toggle="tooltip" data-placement="top" title="{{$pagetype->description_it}}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    @endif
                                </span>
                            </div>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
