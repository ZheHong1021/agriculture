@extends('layouts.admin')
@section('content')
<div class="row">
  <nav class="col-4">
      <ol id="breadcrumbWhite" class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">首頁</a></li>
        <li class="breadcrumb-item active">使用者管理</li>
      </ol>
  </nav>
  <div class="col-8 pt-1 text-right dropdown-no-icon">
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-th-list"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{route('admin.user.create')}}" class="btn btn-primary">新增使用者</a>
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
    <table class="table mb-0">
      <thead>
        <th style="border-top: 0;">使用者帳號</th>
        <th style="border-top: 0;" class="text-center">使用者權限</th>
        <th style="border-top: 0;"></th>
      </thead>
      <tbody>
          <?php
          for($i = 0; $i < count($users); $i++){
          ?>
          <tr>
            <td><a data-toggle="modal" data-target="#<?=@$users[$i]['id']?>_info"><?=@$users[$i]['acc']?></a></td>
            <td class="text-center">
              {{$users[$i]['identity']}}
            </td>
            @if(Auth::user()->authority == 1 && $users[$i]['authority'] != 1)
              <td>
                <form class="text-center" action="{{route('admin.user.delete', ['id'=>$users[$i]['id']])}}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <a href="{{route('admin.user.edit', ['id'=>$users[$i]['id']])}}" title="修改資料" class="btn btn-warning"><i class="far fa-edit"></i></a>
                  <a href="{{route('admin.user.password.reset', ['id'=>$users[$i]['id']])}}" title="重設密碼" class="btn btn-danger"><i class="fas fa-key"></i></a>
                  <button type="submit" title="刪除資料" class="btn btn-danger" onclick="return confirm('確定要刪除這位使用者嗎? 系統將無法復原您的刪除')"><i class="far fa-trash-alt"></i></button>
                </form>
              </td>
            @else
              <td class="text-center">
                <a href="{{route('admin.user.password.reset', ['id'=>$users[$i]['id']])}}" title="重設密碼" class="btn btn-danger"><i class="fas fa-key"></i></a>
              </td>
            @endif
          </tr>
          <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="col-12 pr-0">
    @if($users->lastPage() > 1)
      <nav>
        <ul class="pagination justify-content-end">
          @if( $users->currentPage() != 1 )
            <li class="page-item"><a class="page-link" href="{{ $users->url($users->currentPage()-1) }}">Previous</a></li>
          @endif
          @for($i = 1 ; $i <= $users->lastPage(); $i++)

            <li class="page-item {{ ($users->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a></li>
          @endfor
          @if( $users->currentPage() != $users->lastPage() )
            <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
          @endif
        </ul>
      </nav>
    @endif
  </div>
</div>

@endsection