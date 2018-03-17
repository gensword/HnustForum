@extends('user.edit')

@section('form')
    <span class="iconfont icon-icon" aria-hidden="true" style="font-size: 25px"></span><span style="font-size: 25px"> 消息通知设置</span>
    <hr>
    <div class="switch switch-large" id="mySwitch">
        <input type="checkbox" id="privateMessage" checked /><span style="font-size: 16px">&emsp;私信提醒</span>
    </div>
    <div class="switch switch-large" id="mySwitch" style="margin-top: 10px">
        <input type="checkbox" id="notify" checked /><span style="font-size: 16px">&emsp;系统通知提醒</span>
    </div>
    <div class="switch switch-large" id="mySwitch"  style="margin-top: 10px">
        <input type="checkbox" id="follow" checked /><span style="font-size: 16px">&emsp;关注者动态提醒</span>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            $.post('{{ url('/users/getNotifyStatus') }}', {user_id:'{{ $user->id }}'}, function(data){
                switch (data){
                    case '0':
                        $('#mySwitch input').bootstrapSwitch('state', false);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break;
                    case '1':
                        $('#privateMessage').bootstrapSwitch('state', false);
                        $('#notify').bootstrapSwitch('state', false);
                        $('#follow').bootstrapSwitch('state', true);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break;
                    case '2':
                        $('#follow').bootstrapSwitch('state', false);
                        $('#notify').bootstrapSwitch('state', true);
                        $('#privateMessage').bootstrapSwitch('state', false);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break
                    case '3':
                        $('#notify').bootstrapSwitch('state', true);
                        $('#follow').bootstrapSwitch('state', true);
                        $('#privateMessage').bootstrapSwitch('state', false);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break;
                    case '4':
                        $('#privateMessage').bootstrapSwitch('state', true);
                        $('#follow').bootstrapSwitch('state', false);
                        $('#notify').bootstrapSwitch('state', false);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break;
                    case '5':
                        $('#privateMessage').bootstrapSwitch('state', true);
                        $('#notify').bootstrapSwitch('state', false);
                        $('#follow').bootstrapSwitch('state', true);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                        break;
                    case '6':
                        $('#follow').bootstrapSwitch('state', false);
                        $('#privateMessage').bootstrapSwitch('state', true);
                        $('#notify').bootstrapSwitch('state', true);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                    default: $('#mySwitch input').bootstrapSwitch('state', true);
                        $('#mySwitch input').bootstrapSwitch('disabled', true);
                }
            });
        });

       setTimeout(function(){
           $('#mySwitch input').bootstrapSwitch('disabled', false);
           $('#mySwitch input').on('switchChange.bootstrapSwitch', function (event,state) {
               $.post('{{ url('/users/setNotifyStatus') }}', {setContent:this.id, notifyStatus:state});
           });
       },1000);

        $('#top').click(function(){
        $("html,body").animate({scrollTop:0}, 1000);
        })
    </script>
@stop