@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    notifications = {!! json_encode($notifications->toArray()) !!};
</script>
<div class="container">
    <div id="notification-index">
        <div class="item-cont h-100">
            <div class="item-style h-100">
                <h1>{{__('Notifications')}}</h1>
                <div class="not-cont">
                    <a :class="notification.read?'not-item':'not-item active'" v-for="notification in notifications"
                    @click="readNotifications(notification)"
                    href="#"
                    {{-- :href="
                    notification.type==0?'/admin/accounts/':'/admin/startup/'
                    + notification.ref_account_id" --}}
                    v-cloak>
                        <span>@{{notification.message}}</span>
                        <span class="mini-txt">@{{getDate(notification.created_at)}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
