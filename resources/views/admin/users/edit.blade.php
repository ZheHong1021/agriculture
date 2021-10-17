@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">使用者管理</a></li>
    <li class="breadcrumb-item" >修改使用者</li>
    <li class="breadcrumb-item active" aria-current="page">{{$user['acc']}}</li>
  </ol>
</nav>
<form method="POST" action="{{ route('admin.user.update',['id' => $user['id']]) }}">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ method_field('PATCH') }}
    <h5 class="mt-2"><i class="fas fa-edit"></i> 基本資料</h5>
    <hr>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>使用者帳號</label>
        <input type="text" name="acc" class="form-control" placeholder="請輸入使用者" value="{{$user['acc']}}" readonly="true">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>使用者權限</label>
        <select class="form-control" name="authority">
          <option value="2"  {{$user['authority'] == '2' ? "selected" :  ""  }} >一般管理者</option>
          <option value="3"  {{$user['authority'] == '3' ? "selected" :  ""  }}>訪客</option>
          <option value="4"  {{$user['authority'] == '4' ? "selected" :  ""  }}>停權</option>
        </select>
        @if($errors->has('authority'))
          <small class="text-danger">{{ $errors->first('authority') }}</small>
        @endif
      </div>
    </div>

    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" class="btn btn-danger" onclick="return confirm('確定要取消這次的修改嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>
</form>
@endsection
