<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rokkit:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/frontend/login.css') }}">
</head>
<body>
    <div class="front-login-bg" style="background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(22,38,22,1) 100%), url('{{ asset('backend/images/background/DeWatermark.ai.png') }}') center center / cover no-repeat;">
        <form class="front-login-container" method="POST" action="{{ route('frontend.staff.reset.process') }}">
            @csrf
            <img src="{{ asset('frontend/img/deficon.png') }}" alt="BrewCash Logo" class="brewcash-logo">

            <div class="staff-login-title" style="margin-bottom: 20px;">Identity Verified!</div>
            <p style="font-family: 'Rokkit', serif; color: #333; font-size: 18px; text-align:center; margin-bottom: 30px;">
                Click the button below to reset your password to the default.
            </p>
            
            <button type="submit" class="login-btn" style="background-color: #d32f2f;">Confirm Password Reset</button>

            <div style="text-align:center; margin-top:18px;">
                <a href="{{ route('frontend.staff.forgot') }}" style="color:#163616; font-family:'Rokkit',serif; font-size:15px; text-decoration:underline;">
                    Cancel and Go Back
                </a>
            </div>
        </form>
    </div>
</body>
</html>