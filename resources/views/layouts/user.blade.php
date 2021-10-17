<html>
<head>
	<title>高科大農業環境資訊平台</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
  @yield('meta')
</head>
<body>

<header>
  <nav id="user-navbar" class="navbar navbar-expand-lg navbar-light">  
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="{{route('home.index')}}">
      	<img src="{{asset('images/farmer.png')}}" width="64" height="64" class="d-inline-block align-middle mr-2">
      	高科大農業環境資訊平台
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
  
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
          
          @if(!Auth::check())
          <li class="nav-item">
            <a class="nav-link p-2" href="logout.php">登入</a>
          </li>
          @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2" href="#" id="navbarDropdown" data-toggle="dropdown">
              Hello! {{ Auth::user()->acc }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('admin.user.password.show') }}">修改密碼</a>
              @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.report.index')}}">管理後臺</a>
              @endif  
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('login.logout') }}">登出</a>
            </div>
          </li>
          @endif
        </ul>
      </div>
    </div> 
  </nav>
</header> 
<section id="main">
  @yield('content')
</section>
<footer>
  <center>Copyright © 2018 高科大 資訊管理系(第一校區) E527實驗室 版權所有&emsp;|&emsp;Design by Wuyu&emsp;|&emsp;圖標來源 <a target="_blank" href="https://www.flaticon.com/">www.flaticon.com</a></center>
</footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
@yield('js')
</body>
</html>