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
                <div class="not-cont custom-scrollbar">
                    <a v-for="notification in notifications"
                    :href="notification.notification_type.url + notification.parameter"
                    :class="notification.read?'not-item':'not-item active'" v-cloak>
                        <div class="">
                          <strong>@{{notification.name}}</strong>
                          <span>@{{notification.notification_type.message_it}}</span>
                          <strong>@{{notification.end_name}}</strong>
                          <strong>@{{notification.name_type}}</strong>
                        </div>
                        <span class="mini-txt">@{{getDate(notification.created_at)}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
