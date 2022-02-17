@extends('layouts.app')

@section('content')
<div class="container">
    <div id="topic-create">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.topics.store') }}">
                @csrf
                
                <div class="pt-3 pb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label  for="name" class="">{{__('Title')}}*</label>
                    <div class="">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="title" value="{{ old('name') }}" minlength="10" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{__($message)}}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="pt-3 pb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label  for="description" class="">{{__('Description')}}*</label>
                    <textarea name="description" rows="8" cols="80" class="form-control" placeholder="" min="50" required></textarea>
                    @error ('description')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pt-3 pb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label  for="file" class="">Allega file</label>
                    <div class="">
                        <input type="file" name="" multiple="multiple">
                    </div>
                </div>

                <div class="pt-2 pb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <button type="submit" class="button-style button-color">
                        {{__('Confirm')}}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
