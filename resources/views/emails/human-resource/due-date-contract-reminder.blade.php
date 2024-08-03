@extends('emails.template')

@section('content')
    <div style="align-content: center;position: center;text-align: center">
        <div class="title" style="text-align: center">Reminder Contract {{ $employeeName  }}</div>
        <hr>
        <div style="align-content: left;position: left;text-align: left">
            <h4>Hey {{ $reviewerName }}</h4>
            <h5>You as manager of {{ $employeeName }}, please update the contract of ({{ $employeeName }}) before the
                contract expires on {{ $contractExpired }}: </h5>
        </div>
        <div style="align-content: center;position: center;text-align: center">
            <a href="{{ $callbackUrl }}" style="text-decoration:none; background-color: #01A408; color: white; border-radius: 5px; text-align: center; padding: 10px"
               target="_blank">Update Contract</a>
        </div>
    </div>
@stop