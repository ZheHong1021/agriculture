<html>
<head>
	<title>高科大農業環境資訊平台</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
<div style="height:100vh;" class="jumbotron jumbotron-fluid mb-0">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-12 text-center">
                <img class="ml-4 mb-4" height="200" src="{{ asset('images/farmer.png') }}">
                <h1 class="display-1"><b>@yield('errorCode')</b></h1>
                <h2>@yield('errorMsg')</h2>
                <h4 class="mt-4"><a href="{{route('home.index')}}"><i class="far fa-hand-point-right"></i> 回農業資訊平台 <i class="far fa-hand-point-left"></i></a></h4>
            </div>
            <div class="col-12 text-center mt-5">
                
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</body>
</html>