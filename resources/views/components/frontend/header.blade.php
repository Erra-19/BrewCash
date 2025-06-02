<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewCash - POS</title>
    <link rel="stylesheet" href="{{asset('backend/dist/css/frontend/cashier-pos.css')}}">
    <link rel="preconnect" href="[https://fonts.googleapis.com](https://fonts.googleapis.com)">
    <link rel="preconnect" href="[https://fonts.gstatic.com](https://fonts.gstatic.com)" crossorigin>
    <link href="[https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Rokkit:wght@500;700&display=swap](https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Rokkit:wght@500;700&display=swap)" rel="stylesheet">
    <link href='[https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css](https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css)' rel='stylesheet'>
</head>
<body>
    <div class="page-wrapper">
    <header class="main-header">
        <div class="header-left">
            <img src="{{asset('frontend/img/icon.png')}}" class="logo"></img>
            <p class="current-date">{{ \Carbon\Carbon::now()->format('l, d F') }}</p>
        </div>
        <div class="staff-order">Total order:xx</div>
        <div class="header-right">
            <div class="header-info">
                <a href="#" class="report-btn">Orders</a>
            </div>
            <div class="user-profile-dropdown">

                <div class="user-profile">
                    <img src="{{ asset('storage/img-staff/img-default.jpg') }}" alt="User Avatar" class="user-avatar">
                    <div class="user-info">
                        <span class="user-name">{{$user->name}}</span>
                        <span class="user-role">{{$storeRole}}</span>
                    </div>
                </div>
            
                <div class="dropdown-content">
                    <form method="POST" action="{{ route('frontend.logout') }}">
                        @csrf <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            
            </div>
        </div>
    </header>
    {{$slot}}
</body>
</html>