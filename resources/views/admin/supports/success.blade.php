@extends('layouts.app')

@section('content')
<div id="support-create" class="container">
    <div class="item-cont">
        <div class="item-style">
            <h2>Messaggio inviato correttamente</h2>
            <a class="button-style button-color"
            href="{{ route('admin.search') }}">
                Torna alla Home
            </a>
        </div>
    </div>
</div>
@endsection
