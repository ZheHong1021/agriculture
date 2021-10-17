@extends('layouts.admin')
@section('content')   
  <div class="row">
    <nav class="col-4">
        <ol id="breadcrumbWhite" class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
          <li class="breadcrumb-item active">檢測資料</li>
        </ol>
    </nav>

    <div class="col-8 pt-1 text-right dropdown-no-icon">
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-th-list"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="{{route('admin.report.create')}}" class="btn btn-primary">新增檢測資料</a>
          <a class="dropdown-item" href="{{route('admin.report.upload')}}" class="btn btn-success">匯入資料</a>
          <a class="dropdown-item" href="{{route('admin.report.average.index')}}" class="btn btn-info">管理全部測點平均值</a>
        </div>
      </div>
    </div>

    @if (Session::has('successMessage'))
      <div class="col-12 alert alert-success" role="alert">
        {{ Session::get('successMessage') }}
      </div>
    @endif
    @if (Session::has('errorMessage'))
      <div class="col-12 alert alert-danger" role="alert">
        {{ Session::get('errorMessage') }}
      </div>
    @endif

    <div class="list-session col-12">
      @if(count($info) <= 0)
        <center><p class="text-secondary pt-2">目前沒有任何檢測資料</p></center>
      @else
        <table class="table mb-0">
          <thead>
            <th style="border-top: 0;">點位</th>
            <th style="border-top: 0;">場主</th>
            <th style="border-top: 0;">種植種類</th>
            <th style="border-top: 0;">種植方式</th>
            <th style="border-top: 0;">新增日期</th>
            <th style="border-top: 0;">最後更新日期</th>
            <th style="border-top: 0;"></th>
          </thead>
          <tbody>
              @for($i = 0; $i < count($info); $i++)
              <tr>
                <td>#{{ $info[$i]['no'] }}</td>
                <td>{{ $info[$i]['name'] }}</td>
                <td>{{ $info[$i]['species'] }}</td>
                <td>{{ $info[$i]['method'] }}</td>
                <td>{{ $info[$i]['created_at'] }}</td>
                <td>{{ $info[$i]['updated_at'] }}</td>

                <td>
                  <form class="text-center" action="{{route('admin.report.destroy', ['id'=>$info[$i]['id']])}}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <a href="{{ route('admin.report.edit', ['id' => $info[$i]['id']]) }}" title="修改資料" class="btn btn-warning"><i class="far fa-edit"></i></a>
                    <button type="submit" title="刪除資料" class="btn btn-danger" onclick="return confirm('確定要刪除這筆資料嗎? 系統將無法復原您的刪除')"><i class="far fa-trash-alt"></i></button>
                  </form>
                </td>
              </tr>
              @endfor
          </tbody>
        </table>
      @endif  
    </div>
    <div class="col-12 pr-0">
      @if($info->lastPage() > 1)
        <nav>
          <ul class="pagination justify-content-end">
            @if( $info->currentPage() != 1 )
              <li class="page-item"><a class="page-link" href="{{ $info->url($info->currentPage()-1) }}"><</a></li>
            @endif
            @for($i = 1 ; $i <= $info->lastPage(); $i++)
              <li class="page-item {{ ($info->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="{{ $info->url($i) }}">{{ $i }}</a></li>
            @endfor
            @if( $info->currentPage() != $info->lastPage() )
              <li class="page-item"><a class="page-link" href="{{ $info->nextPageUrl() }}">></a></li>
            @endif
          </ul>
        </nav>
      @endif
    </div>
  </div>

@endsection