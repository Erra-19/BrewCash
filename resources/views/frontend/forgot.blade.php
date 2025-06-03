<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rokkit:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/frontend/login.css') }}">
</head>
<body>
    <div class="front-login-bg" style="background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(22,38,22,1) 100%), url('{{ asset('backend/images/background/DeWatermark.ai.png') }}') center center / cover no-repeat;">
        <form class="front-login-container" method="POST" action="{{ route('frontend.staff.verify') }}">
            @csrf
            <img src="{{ asset('frontend/img/deficon.png') }}" alt="BrewCash Logo" class="brewcash-logo">

            <div class="staff-login-title" style="margin-bottom: 20px;">Reset Your Password</div>
            <p style="font-family: 'Rokkit', serif; color: #555; font-size: 16px; text-align:center; margin-bottom: 20px;">Please enter your details to verify your identity.</p>
            
            @if ($errors->any())
                <div style="color:#b71c1c; background: #fff3f3; border-radius: 6px; padding: 8px 16px; width: 100%; margin-bottom: 10px; font-family: 'Rokkit', serif; font-size: 16px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="input-group">
                <input type="text" name="user_id" placeholder="Staff ID" value="{{ old('user_id') }}" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Registered Email" value="{{ old('email') }}" required>
            </div>
            <div class="input-group">
                <input type="text" name="phone_number" placeholder="Registered Phone Number" value="{{ old('phone_number') }}" required>
            </div>

            <button type="submit" class="login-btn">Verify Identity</button>
             <div style="text-align:center; margin-top:18px;">
                <a href="{{ route('frontend.login') }}" style="color:#163616; font-family:'Rokkit',serif; font-size:15px; text-decoration:underline;">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</body>
</html>