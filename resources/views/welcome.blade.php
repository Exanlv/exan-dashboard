@extends('base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h4>About</h4>
            <p>
                An easy-ish to use bot to handle self-assignable roles on your discord guild. <br /><br />
                Features: <br />
            <ul>
                <li>Multi-language support</li>
                <li>Global emotes for reaction roles</li>
                <li>Auto role restore</li>
                <li>Get/remove role commands</li>
                <li>Easy setup</li>
                <li>Opensource!</li>
            </ul>
            </p>
        </div>
        <div class="col-12 col-md-6">
            <h4>Configuration</h4>
            <p>
                You can configure the bot to your needs using this dashboard.
                Click the button in the top right to get started.

                <br /><br />
                Note: none of your account details are stored.
                Logging in is only used to verify you have access to configure the bot for a server.
            </p>
        </div>
    </div>
</div>
@endsection
