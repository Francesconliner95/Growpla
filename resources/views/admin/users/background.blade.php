@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user_backgrounds = @json($user_backgrounds);
    backgrounds = @json($backgrounds);
</script>
<div id="user-background" style="background-image: url({{asset("storage/users_images/default-studente.svg") }}); background-position: right -150px top -50px; background-repeat: no-repeat; background-size: 500px 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <div class="header pb-3">
                    <h2>Formazione</h2>
                </div>
                <form method="POST" action="{{ route('admin.users.storeBackground',$user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="pt-2 pb-5">
                        <div v-for="(background,i) in user_backgrounds" class="border-style bg-blue" v-cloak>
                            @{{background.name}}
                            <input type="hidden" name="backgrounds[]" :value="background.id">
                            <i class="fas fa-times scale" @click="removeBackground(i)"></i>

                            {{-- <div class="img-cont icon-img scale" @click="removeBackground(i)">
                                <img src="{{asset('storage/images/icon-x.svg')}}" alt="">
                            </div> --}}
                        </div>
                    </div>
                    <div class="pb-5">
                        <h6>Inserisci il tuo campo di studi</h6>
                        <div class="from-group row pr-3 pl-3">
                            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-1">
                                <select class="form-control custom-select-green" name="" @change="addBackground()" v-model="background_selected">
                                    <option value="">Seleziona formazione</option>
                                    <option  v-for="background in backgrounds" :value="background">@{{background.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5">
                        <div class="">
                            <a href="{{ route('admin.supports.create') }}" class="font-weight-bold mini-txt txt-green">
                                Suggerisci altre aree di formazione
                            </a>
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
