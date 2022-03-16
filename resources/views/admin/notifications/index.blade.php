@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="notification-index">
        <div class="item-cont h-100">
            <div class="item-style h-100">
                <h1>{{__('Notifications')}}</h1>
                <div class="not-cont">
                    {{-- <a :class="notification.read?'not-item':'not-item active'" v-for="notification in notifications"
                    @click="readNotifications(notification)"
                    href="#"
                    v-cloak>
                        <span>@{{notification.message}}</span>
                        <span class="mini-txt">@{{getDate(notification.created_at)}}</span>
                    </a> --}}
                    <a v-for="notification in notifications"
                    :href="notification.ref_user_id?'/admin/users/'+ notification.ref_user_id : '/admin/pages/'+ notification.ref_page_id" :class="notification.read?'not-item':'not-item active'" v-cloak>
                        <div class="">
                          <strong>@{{notification.name}}</strong>
                          <span>@{{notification.notification_type.message_it}}</span>
                        </div>                      
                        <span class="mini-txt">@{{getDate(notification.created_at)}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
