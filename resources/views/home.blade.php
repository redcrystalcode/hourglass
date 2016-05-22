@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!

                    <p>
                        This application is in an early alpha undergoing rapid development.
                    </p>

                    <h3>Employees</h3>
                    <ul class="list-group">
                        @foreach ($employees as $employee)
                            <li class="list-group-item">
                                <h4>{{ $employee->name }}</h4>
                                <p>{{ $employee->position }} - Card {{ $employee->terminal_key }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <h3>Locations</h3>
                    <ul class="list-group">
                        @foreach ($locations as $location)
                            <li class="list-group-item">
                                <h4>{{ $location->name }}</h4>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
