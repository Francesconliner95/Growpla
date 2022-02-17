@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    account_id = "{{$account_id}}";
    lang = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="nomination-startup">
        <div :class="delete_alert?'delete-alert active-alert':'delete-alert deactive-alert'" v-cloak>
            <div class="item-cont delete-alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style">
                    <button type="button" name="button" class="edit-top-right button-style button-color" @click="rejectDelete()">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">@{{delete_message}}
                    </h3>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="rejectDelete()">
                            {{__('Cancel')}}
                        </button>
                        <button class="button-style button-color-red ml-5" type="button" name="button" @click="deleteNomination()">
                            <i class="fas fa-trash-alt mr-1"></i>{{__('Proceed')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <h2>{{__('Nominations')}}</h2>
                <div v-if="nominations.length>0">
                    <div  v-for="nomination in nominations" class="d-flex justify-content-between align-items-center">
                        <div class="mb-1">
                            <a :href="'/admin/accounts/' + nomination.cofounder_account_id" class="button-style button-color-blue">
                                <span class="text-capitalize">
                                    <i class="fas fa-briefcase"></i>
                                    @{{nomination.role_name}}
                                </span>
                                <span class="pl-2">
                                    <i class="fas fa-user-tie"></i>
                                    @{{nomination.name}}
                                </span>
                            </a>
                        </div>
                        <div class="">
                            <a type="button" name="button" class="button-style button-color" @click="sendMessage(nomination.cofounder_account_id)">
                                {{-- <i class="fas fa-comment"></i> --}}
                                {{__('Send Message')}}
                            </a>
                            <a type="button" name="button" class="button-style button-color-orange"
                            @click="deleteController(1,nomination.id)">
                                {{-- <i class="fas fa-times"></i> --}}
                                {{__('Reject nomination')}}
                            </a>
                            <a type="button" name="button" class="button-style button-color-red"
                            @click="deleteController(2,nomination.id)">
                                {{__('Delete')}}
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else class="">
                    <p>{{__('No candidate')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
