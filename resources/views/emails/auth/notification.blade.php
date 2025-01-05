@extends('emails.template')

@section('content')
    <div class="title">Login Attempt</div>
    <br>
    <div class="body-text">
        Hi {{ $username }},
        <br><br>
        We've detected a login to your account from a device we don't recognize.
        <br>
        If this was you, no action is needed.
        <br>
        If you didn't authorize this login, please secure your account immediately by following these steps: 
        <br><br>
        1. Reset your password now. <a href="{{ $url }}">{{ $url }}</a>.
        <br><br>
        Your account security is our top priority. If you need assistance, feel free to contact our support team.
        <br><br>
        Stay secure,
        <br>
        Pointhub.
    </div>
@stop
