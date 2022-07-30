@extends('layouts.app')

@section('content')
<div id="support-create" class="bg-blue" style="background-image: url({{asset("storage/images/bg-contact.svg") }}); background-position: left 0px bottom 0px; background-repeat: no-repeat; background-size: 500px;">
    <div class="container">
      <div class="item-cont">
          <div class="item-style">
              <form method="POST" action="{{route('admin.supports.store')}}" enctype="multipart/form-data" name="formNameSupport">
                  @csrf
                  <div class="row justify-content-around">
                      <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 txt-green p-2">
                          <div class="bg-white p-4" style="border-radius: 20px;">
                              <h5 class="text-center font-weight-bold">CONTATTACI</h5>
                              <div class="pt-3 pb-3">
                                  <h6>{{__('Select area')}}</h6>
                                  <select class="form-control" name="support_type_id">
                                      @foreach ($supportTypes as $supportType)
                                          <option value="{{$supportType->id}}">
                                              {{$supportType->name_it}}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error ('support_type_id')
                                      <div class="alert alert-danger">
                                          {{__($message)}}
                                      </div>
                                  @enderror
                              </div>
                              <div class="pt-3 pb-3">
                                  <h6>{{__('Title')}}</h6>
                                  <div class="">
                                      <input type="text" name="title" class="form-control" max="50" value="" required>
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
                                      <textarea name="description" rows="5" cols="80" class="form-control" min="100" required></textarea>
                                      @error ('description')
                                          <div class="alert alert-danger">
                                              {{__($message)}}
                                          </div>
                                      @enderror
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 p-2">
                          <div class="bg-dark p-4 h-100" style="border-radius: 20px;">
                              <h5 class="text-center font-weight-bold">ALLEGA FILE</h5>
                              <div class="pt-3 pb-4 h-100">
                                  <div class="drop-zone">
                                      <span class="drop-zone__prompt h-100">{{__('Drop file here or click to upload')}}</span>
                                      <input ref="mainFile" type="file" class="form-control-file drop-zone__input" name="file" accept="image/*">
                                      @error ('file')
                                          <div class="alert alert-danger">
                                              {{__($message)}}
                                          </div>
                                      @enderror
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="pt-4 pb-2 text-center">
                      <button type="submit" class="button-style button-color">
                          {{__('Send Message')}}
                      </button>
                  </div>
              </form>
              <div class="text-right font-weight-bold">
                  @if(in_array(Auth::user()->id,$admins))
                      <a href="{{route('admin.supports.index')}}">
                          Opzioni Admin
                      </a>
                  @endif
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
