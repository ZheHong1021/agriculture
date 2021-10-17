<html>
<head>
	<title>高科大農業環境資訊平台</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<body>

<header class="mb-2">
  <nav id="admin-navbar" class="navbar navbar-expand-lg navbar-dark bg-dark">  
    <div class="container-fluid">
      <a class="navbar-brand text-white font-weight-bold">
      	高科大農業環境資訊平台 管理後臺
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
          @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
            <li class="nav-item">
              <a class="nav-link text-white p-2" href="{{route('admin.report.index')}}">檢測報告管理</a>
            </li>
  	        @if(Auth::user()->isSuperAdmin())
  	        <li class="nav-item">
  	          <a class="nav-link text-white p-2" href="{{route('admin.user.index')}}">使用者管理</a>
  	        </li>
  	        @endif
          @endif
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
          @if(! Auth::check())
          <li class="nav-item">
            <a class="nav-link p-2" href="logout.php">登入</a>
          </li>
          @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-2 text-white" href="#" id="navbarDropdown" data-toggle="dropdown">
              Hello! {{ Auth::user()->acc }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('admin.user.password.show') }}">修改密碼</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{route('home.index')}}">回首頁</a>
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
<section id="admin-main">
  <div class="container-fluid">
    @yield('content')
  </div>
</section>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

@yield('js')
</body>
</html>