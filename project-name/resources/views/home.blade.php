@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        Your application's dashboard.
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>


@if(isset($slackUserCount) || isset($slackUsers))
    <div class="container">
        <div class="container">
            <div class="row">
                @if($channels)
                <div class="col-md-4">
                    <h2>My Cannels</h2>
                    <h3>Total Number  <span class="badge badge-success">{{ count($channels) }}</span></h3>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">SEE CHANNELS NAME
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu my_dropdown_height">
                            @foreach($channels as $curr_channel)
                                <li class="list-group-item">{{ $curr_channel->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="col-md-5">
                    <h2>Slack Users</h2>
                    <h3>Users Count  <span class="badge badge-success">{{ $slackUserCount }}</span></h3>
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">SEE USERS
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu my_dropdown_height_users">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="slack_info_center">Name</th>
                                    <th class="slack_info_center">Email</th>
                                    <th class="slack_info_center">Disconnect</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($slackUsers as $slackUser)
                                    <tr>
                                        <td class="slack_info_center">{{$slackUser->name}}</td>
                                        <td class="slack_info_center">{{$slackUser->email}}</td>
                                        <td class="icons_disccount"><i data-id="{{ $slackUser->id }}" class="fa fa-minus-circle fa-2x detach_user_a" aria-hidden="true"></i></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.detach_user_a').click(function(){
            var id = $(this).data('id');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                type: 'POST',
                url: 'detachUser',
                data: {
                    '_token':_token,
                    '_method':'delete',
                    'id': id
                },
                dataType:'json',
                success: function(res){
                    if(res.error){
                        location.reload();
                    }
                }
            });
        });
    });
</script>



@endsection
