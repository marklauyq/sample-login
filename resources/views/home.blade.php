@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!

                        <p>This is your account activity</p>
                        <table style="width:100%">
                            <tr>
                                <th>No. </th>
                                <th>DateTime</th>
                                <th>Activity</th>
                                <th>Status</th>
                            </tr>

                            @foreach($logs as $index=>$log)
                                <tr>
                                    <td> {{$index}} </td>
                                    <td> {{$log['datetime']}} </td>
                                    <td> {{$log['activity']}} </td>
                                    <td> {{$log['status']}} </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
