@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="nomination-index">
        <div class="item-cont">
            <div class="item-style">
                <h2>{{__('My nominations')}}</h2>
                @if($accounts)
                    @foreach ($accounts as $account)
                        <div class="">
                            <i class="fas fa-rocket"></i>
                            <a class="mini-txt" href="{{ route('admin.accounts.show', ['account'=> $account->id])}}">
                            <span>{{$account->name}} -</span>
                            <span>{{$account->role}}</span>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p class="mt-3">{{__('No application yet')}},
                        <a class="" href="{{ route('admin.accounts.index')}}">
                        {{__('search')}}
                        </a>
                        {{__('and consult the startup accounts on the platform and candidates through the appropriate section')}}
                        <strong>"{{__('looking for')}}"</strong> {{__('in case you are interested in becoming a member')}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
