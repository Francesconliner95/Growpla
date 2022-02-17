@extends('layouts.app')

@section('content')
<script type="text/javascript">
    support = {!! json_encode($support->toArray()) !!};
</script>
<div id="support-show" class="container">
    <div class="item-cont">
        <div class="item-style">
            <h2>Messaggio</h2>
            <div  class="">
                <form method="post" action="{{ route('admin.supports.destroy', ['support'=> $support->id])}}" class="p-0 m-0 d-inline-block">
                @csrf
                @method('DELETE')
                <button class="button-style button-color ml-5 edit-top-right" type="submit" name="button">
                    Elimina
                </button>
                </form>
                <p>ID: {{$support->id}}</p>
                <p>User_id: {{$support->user_id}}</p>
                <p>User_email: {{$support->user_email}}</p>
                <p>Account:
                    <a href="{{route('admin.accounts.show', $support->account_id)}}">
                        {{$support->account_name}}
                    </a>
                </p>
                <h6>Titolo</h6>
                <p>{{$support->title}}</p>
                <h6>Descrizione</h6>
                <p>{{$support->description}}</p>
                
                @if ($support->file)
                    <h6>File</h6>
                    <embed v-if="extensionsType()=='pdf'" src="{{ asset("storage/" . $support->file) }}" / class="col-12" style="height: 500px">
                    <img v-else src="{{ asset("storage/" . $support->file) }}" alt="" class="profile-image">
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
