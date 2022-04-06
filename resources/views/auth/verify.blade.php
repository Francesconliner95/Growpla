@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
    use App\Language;
    app()->setLocale(Language::find(Auth::user()->language_id)->lang);
@endphp
<div class="container not-log-main-hg">
    <div class="item-cont pt-4">
        <div class="item-style">
            <h6>{{ __('Verify Your Email Address') }}</h6>

            <div class="">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
