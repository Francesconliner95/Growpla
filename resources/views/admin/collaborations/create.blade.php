@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="collaboration-create">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Nuova Collaborazione</h2>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.collaborations.store') }}" name="collaborationForm">
                    @csrf
                    <input type="hidden" name="sender_id" value="{{$my_id}}">
                    <input type="hidden" name="sender_user_or_page" value="{{$user_or_page}}">
                    <input type="hidden" name="recipient_id" :value="account_selected.id">
                    <input type="hidden" name="recipient_user_or_page" :value="account_selected.user_or_page">
                    <div v-if="!account_selected" class="search" v-cloak>
                        <input type="text" name="account" value="" placeholder="Nome pagina o utente" v-model="account_name" @keyup.enter="searchAccount()" v-on:input="searchAccount()" maxlength="70" class="form-control" autocomplete="off" required>
                        @error ('account_name')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                        @enderror
                        <div :class="accounts_found.length>0?'found':'found d-none'" v-cloak>
                            <div class="item" v-for="account_found in accounts_found">
                                <div class="img-cont mini-img">
                                    <img v-if="account_found.image" :src="'/storage/' + account_found.image" alt="">
                                </div>
                                @{{account_found.user_or_page=='user'?
                                account_found.name + ' ' + account_found.surname
                                : account_found.name}}
                                <button type="button" name="button"
                                class="button-style button-color" @click="addAccount(account_found)">Conferma</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
