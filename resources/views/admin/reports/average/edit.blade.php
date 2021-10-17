@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.report.index') }}">檢測資料</a></li>
    <li class="breadcrumb-item active" aria-current="page">修改全部測點平均值</li>
  </ol>
</nav>
<form method="POST" action="{{route('admin.report.average.store')}}" enctype="multipart/form-data">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h5 class="mt-2"><i class="fas fa-edit"></i> 全部測點平均值<small class="pl-2 text-muted">所有數值皆為必填，若無請填0</small></h5>
    <hr>
    <div class="form-inline mb-4 col-12 col-md-4">
      <label>n = </label>
      <input class="form-control ml-2" type="number" name="n" min="0" placeholder="請輸入全部測點平均值的n (n=?)" value="{{ $average[0]->n }}" required>
    </div>
    @if($errors->has('n'))
      <small class="text-danger">請輸入格式正確的n</small>
      <br>
    @endif
    @if($errors->has('average'))
      <div class="alert alert-danger" role="alert">請輸入格式正確的測值 (數字)</div>
    @endif
    <table class="table table-bordered">
      <thead class="bg-dark text-white">
        <td>土壤深度(公分)</td>
        <td>土壤含水率(%)</td>
        <td>土壤有機質(%)</td>
        <td>酸鹼值(pH)</td>
        <td>電導度(μS/cm)</td>
      </thead>
      <tbody>
        @for($i = 0 ; $i < 2; $i++)
          <tr>
            @foreach($averageColumns as $averageColumn)
              <td><input type="text" name="average[{{$i}}][{{$averageColumn}}]" placeholder="{{ $averageChineseColumns[$loop->index] }}" class="form-control" value="{{ $average[$i]->$averageColumn }}" required></td>
            @endforeach
          </tr>
        @endfor  
      </tbody>
    </table>
    <small class="text-secondary">目前資料筆數: {{ $infoCount }}</small>
    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" class="btn btn-danger" onclick="return confirm('確定要取消這次的修改嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>  
</form>

@endsection