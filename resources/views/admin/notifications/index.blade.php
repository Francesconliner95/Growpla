@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>

<div id="notification-index" style="background-image: url({{asset("storage/images/bg-servizi.svg") }}); background-position: right -50px bottom -50px; background-repeat: no-repeat; background-attachment: fixed; background-size: 700px 500px;">
    <div class="container">
        <div class="item-cont h-100">
            <div class="item-style h-100">
                <h1>{{__('Notifications')}}</h1>
                <div class="not-cont custom-scrollbar">
                    <a v-for="notification in notifications"
                    :href="notification.notification_type.url + notification.parameter"
                    :class="notification.read?'not-item':'not-item active'" v-cloak>
                        <div class="d-flex align-items-center">
                          <div class="img-cont tiny-img mr-3">
                              <img :src="'/storage/'+ notification.image" alt="">
                          </div>
                          <div class="">
                              <strong class="text-capitalize ">@{{notification.name}}</strong>
                              <span>@{{notification.notification_type.message_it}}</span>
                              <strong class="text-capitalize">@{{notification.end_name}}</strong>
                              <strong>@{{notification.name_type}}</strong>
                          </div>
                        </div>
                        <span class="mini-txt">@{{getDate(notification.created_at)}}</span>
                    </a>
                    <div v-if="notifications.length==0 && !in_load" class="" v-cloak>
                        <h5>Nessuna notifica</h5>
                    </div>
                    <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
