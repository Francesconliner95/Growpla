@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    userTypes = "{{$userTypes}}";
    pageTypes = "{{$pageTypes}}";
</script>
<div class="container">
    <div id="user-create">
        <div class="item-cont">
            <div class="item-style">
              <h2>Come ti identifichi?</h2>
              <h4>Seleziona una o più delle seguenti alternative</h4>
              <h6>Utenti</h6>
              <div v-for="userType in userTypes" class="">
                <input type="checkbox" name="usertype" :value="userType.id" :id="userType.name">
                <label :for="userType.name">@{{language_id==1?userType.name:userType.name_it}}</label>
              </div>
              <h6>Pagine</h6>
              <div v-for="pageType in pageTypes" class="">
                <input type="checkbox" name="pagetype" :value="pageType.id" :id="pageType.name">
                <label :for="pageType.name">@{{language_id==1?pageType.name:pageType.name_it}}</label>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
