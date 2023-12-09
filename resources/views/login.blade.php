<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('assets/login_page/style.css') }}">
</head>

<body>
    <div id="back">
        <!-- <img src="images/login_background.png" style="max-width: 100%;max-height: 100%;position: absolute;"> -->
        <canvas id="canvas" class="canvas-back"></canvas>
        <div class="backRight">
        </div>
        <div class="backLeft" style="background: green;">
        </div>
    </div>
    <div id="slideBox">
        <div class="topLayer">
            <div class="right">
                <div style="text-align: center; margin-top:50px; ;">
                    <img src="{{ asset('assets/icons/fnlogo.png') }}" width="250">
                    <!-- <h1>Menu Listing</h1> -->
                </div>

                <div class="content">
                    <h2>Hi, </h2>
                    @include('alert.alert')
                    <form id="form-login" method="post" action="{{ route('login.login') }}" autocomplete="off">
                        @csrf
                        <div class="form-element form-stack">
                            <label for="username-login" class="form-label">Username</label>
                            <input id="username-login" type="text" name="username" autofocus="true" placeholder="Username" required>
                            @error('username')
                                <p class="error error-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-element form-stack">
                            <label for="password-login" class="form-label">Password</label>
                            <input id="password-login" type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <p class="error error-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-element form-checkbox">
                            <input id="confirm-terms" type="checkbox" name="rememberme" value="on" class="checkbox"
                                style="border-bottom: none;">
                            <label for="confirm-terms">Remember me</label>
                        </div>
                        <div class="form-element form-submit">
                            <button id="logIn" class="login" type="submit" name="login" style="cursor: pointer;">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src='{{ asset('assets/login_page/jquery.js') }}'></script>
    <script src='{{ asset('assets/login_page/paper-full.min.js') }}'></script>
    <script src="{{ asset('assets/login_page/script.js') }}"></script>
</body>

</html>
