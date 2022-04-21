@extends('layouts.app')

@section('content')
<div id="support-create" class="container">
    <div class="item-cont">
        <div class="item-style">
            <div class="header">
                {{-- Nome --}}
                <div class="">
                    <h2>{{__('Contact us')}}</h2>
                </div>
                <h1>
                    <i class="fas fa-file-signature"></i>
                </h1>
            </div>
            <div class="main-section pt-3 pb-2">
             <form method="POST" action="{{route('admin.supports.store')}}" enctype="multipart/form-data" name="formNameSupport">
                @csrf

                <div class="pt-3 pb-3">
                    <h6>{{__('Select area')}}</h6>
                        <select class="form-control" name="support_type_id">
                            @foreach ($supportTypes as $supportType)
                                <option value="{{$supportType->id}}">
                                    @if ($lang==2)
                                        {{$supportType->name}}
                                    @else
                                        {{$supportType->name_en}}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error ('support_type_id')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-3 pb-3">
                    <h6>{{__('Title')}}</h6>
                    <div class="">
                        <input type="text" name="title" class="form-control" max="50" value="">
                        @error ('title')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-3 pb-3">
                    <h6>{{__('Message')}}</h6>
                    <div class="">
                        <textarea name="description" rows="5" cols="80" class="form-control"></textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-3 pb-3">
                    <h6>{{__('Attach file')}}</h6>
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}</span>
                        <input ref="mainFile" type="file" class="form-control-file drop-zone__input" name="file" accept="image/*">
                        @error ('file')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 pb-3">
                    <button type="submit" class="button-style button-color">
                        {{__('Send Message')}}
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
