@extends('layouts.app')

@section('content')
<div id="support-create"  class="bg-blue" style="background-image: url({{asset("storage/images/bg-contact.svg") }}); background-position: left 0px bottom 0px; background-repeat: no-repeat; background-size: 500px;">
    {{-- <div class="container h-100"> --}}
        <div class="item-cont">
            <div class="item-style">
                  <div class="text-center pt-5 mt-5">
                      <h2>Messaggio inviato correttamente</h2>
                      <a class="button-style button-color"
                      href="{{ route('admin.search') }}">
                          Torna alla Home
                      </a>
                  </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
@endsection
