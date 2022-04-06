@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    followed = "{{$followed}}";
</script>
<div class="container">
    <div  id="follows-index">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <div class="">
                        <h2>Seguiti</h2>
                    </div>
                    <h1>
                        <i class="fas fa-user-check"></i>
                    </h1>
                </div>
                <p v-if="followed.length<1" v-cloak>Nessun seguito</p>
                <div v-for="following in followed" class="sub-item-cont text-capitalize" v-cloak>
                    <div v-if="following.user_id" class="">
                      <a :href="'/admin/users/' + following.user_id" class="">
                          @{{following.user_name}} @{{following.user_surname}}
                      </a>
                      <button type="button" name="button" class="button-style button-color" @click="toggleFollow(following.user_id,1)">
                          <i class="fas fa-user-times"></i>
                      </button>
                    </div>
                    <div v-else class="">
                      <a :href="'/admin/pages/' + following.page_id" class="">
                          @{{following.page_name}}
                      </a>
                      <button type="button" name="button" class="button-style button-color" @click="toggleFollow(following.page_id,2)">
                          <i class="fas fa-user-times"></i>
                      </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
