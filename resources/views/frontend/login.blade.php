<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewCash Staff Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Rokkit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rokkit:wght@500&display=swap" rel="stylesheet">
    <!-- BrewCash CSS -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/frontend/login.css') }}">
</head>
<body>
    <div class="front-login-bg" style="background:
    linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(22,38,22,1) 100%),
    url('{{ asset('backend/images/background/DeWatermark.ai.png') }}') center center / cover no-repeat;">
        <form class="front-login-container" method="POST" action="{{ route('frontend.login.submit') }}">
            @csrf
            <img src="{{ asset('frontend/img/deficon.png') }}" alt="BrewCash Logo" class="brewcash-logo">

            <div class="staff-login-title">Staff please log in first</div>
            
            @if ($errors->any())
                <div style="color:#b71c1c; background: #fff3f3; border-radius: 6px; padding: 8px 16px; width: 100%; margin-bottom: 10px; font-family: 'Rokkit', serif; font-size: 16px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="input-group">
                <div class="input-group-icon">
                    <img src="{{ asset('frontend/img/Profile.png') }}" alt="User Icon" width="38" height="38" style="width:38px;height:38px;">
                </div>
                <input type="text" name="user_id" placeholder="Staff ID" value="{{ old('user_id') }}" required autocomplete="username">
            </div>
            <div class="input-group">
                <div class="input-group-icon">
                    <img src="{{ asset('frontend/img/key.png') }}" alt="Key Icon" width="38" height="38" style="width:38px;height:38px;">
                </div>
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
            </div>
            <button type="submit" class="login-btn">Log In</button>
        </form>
    </div>
</body>
</html>