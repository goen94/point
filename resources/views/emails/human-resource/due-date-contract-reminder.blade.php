@extends('emails.template')

@section('content')
<div style="align-content: center;position: center;text-align: center">
  <div class="title" style="text-align: center">Reminder Contract {{ $employeeName  }}</div>
  <hr>
  <div style="align-content: left;position: left;text-align: left">
    <h4>Hey {{ $reviewerName }}</h4>
    <h5>You as manager of {{ $employeeName }}, please update the contract of ({{ $employeeName }}) before the contract expires on {{ $contractExpired }}: </h5>
  </div>
</div>
@stop