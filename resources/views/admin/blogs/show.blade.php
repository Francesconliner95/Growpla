@extends('layouts.app')

@section('content')
<script type="text/javascript">
    support = @json($support);
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
                <p>Data: {{$support->created_at}}</p>
                <p>User_id: {{$user->id}}</p>
                <p>User_email: {{$user->email}}</p>
                <p>User:
                    <a href="{{route('admin.users.show', $user->id)}}" class="text-capitalize">
                        {{$user->name}} {{$user->surname}}
                    </a>
                </p>
                <h6>Titolo</h6>
                <p>{{$support->title}}</p>
                <h6>Descrizione</h6>
                <p>{{$support->description}}</p>

                @if ($support->file)
                    <h6>File</h6>
                    <embed v-if="extensionsType()=='pdf'" src="{{ asset("storage/" . $support->file) }}" / class="col-12" style="height: 500px; object-fit: contain;">
                    <img v-else src="{{ asset("storage/" . $support->file) }}" alt="" class="col-12" style="height: 500px; object-fit: contain;">
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
