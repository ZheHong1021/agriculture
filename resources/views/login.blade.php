<html>
<head>
	<title>高科大農業環境資訊平台</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<body>
<div id="loginPage" class="jumbotron jumbotron-fluid mb-0">
  <div class="container">
    <form action="{{route('login.login')}}" method="POST" id="loginBox" class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-12 offset-0 align-middle">
    	<center><h4 class="font-weight-bold mb-5">高科大農業環境資訊平台</h4></center>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
    	<div class="form-group mt-5">
    		<label>帳號</label>
    		<input type="text" name="acc" class="form-control">
    	</div>
    	<div class="form-group mt-2">
    		<label>密碼</label>
    		<input type="password" name="password" class="form-control">
    	</div>
        @if($errors->has('session'))
            <div class="form-group mt-2">
                <small class="text-danger">連線逾時，請再重新登入一次</small>
            </div>
        @elseif (count($errors) > 0)
            <div class="form-group mt-2">
                <small class="text-danger">帳號或密碼錯誤，請再重新輸入一次</small>
            </div>
        @endif
        @if(Session::has('successMessage'))
            <div class="form-group mt-2">
                <small class="text-success">{{ Session::get('successMessage') }}</small>
            </div>
        @endif
        
    	<div class="form-group text-right mt-5">
    		<button type="submit" class="btn btn-primary">登入</button>
    	</div>
    </form>
  </div>
</div>

</body>
</html>