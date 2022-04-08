@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    lifecycles = {!! json_encode($lifecycles->toArray()) !!};
    lifecycle_id = "{{$page->lifecycle_id}}";
</script>
<div class="container">
    <div id="lifecycle-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h2>{{__('Life cycle')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form method="POST" id="editPageForm" enctype="multipart/form-data" action="{{ route('admin.lifecycles.update', $page->id) }}">
                    @csrf
                    @method('PUT')
                    <h6>Seleziona fase del ciclo di vita in cui ti trovi
                    </h6>
                    <div class="row d-flex justify-content-center">
                        @foreach ($lifecycles as $lifecycle)
                            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-2">
                                <button type="button" name="button" :class="isChecked('l-{{$lifecycle->id}}')?
                                'active multichoise-b button-style multichoise-green w-100 lifecycle-item tool-tip-b':
                                'multichoise-b button-style multichoise-green w-100 lifecycle-item tool-tip-b'" @click="radioToggle({{$lifecycle->id}})" id="l-{{$lifecycle->id}}-b" v-cloak>
                                    <input id="l-{{$lifecycle->id}}" type="radio" name="lifecycle" class="d-none" value="{{$lifecycle->id}}">
                                    <span>{{$lifecycle->name}}
                                    </span>
                                    @if($lifecycle->description_it)
                                    <div class="tool-tip">
                                        {{$lifecycle->description_it}}
                                    </div>
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="button-style button-color">
                        {{__('Save Changes')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
