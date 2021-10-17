@extends('layouts.user')
@section('content')
<div class="row report-section">
  <nav>
    <ol id="breadcrumbWhite" class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
      <li class="breadcrumb-item active">檢測資料</li>
      <li class="breadcrumb-item active" aria-current="page">場主 {{ $info->name }}</li>
    </ol>
  </nav>
  <div class="col-12">
    @foreach($arr_basicsKey as $basicsKey)
      <table class="table table-bordered">
        <thead>
          <tr class="bg-dark text-white">
            <th>點位</th>
            <th class="text-center" colspan="2">{{ $basicsKey }}</th>
            <th>
          </tr>
          <tr class="bg-dark text-white">
            <th>第一層</th>
            <th class="text-center" colspan="2">基本資料</th>
            <th>
          </tr>
          <tr>
            <th width="25%">座標</th>
            <th width="25%">種植種類</th>
            <th width="25%">種植方式</th>
            <th width="25%">場主</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $info->lat }}, {{ $info->lng }}</td>
            <td>{{ $info->species }}</td>
            <td>{{ $info->method }}</td>
            <td>{{ $info->name }}</td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>第二層</th>
            <th class="text-center" colspan="3">基本測值</th>
            <th>
          </tr>
          <tr class="text-center">
            <th width="20%">土壤<br>深度(公分)</th>
            <th width="20%">土壤<br>含水率(%)</th>
            <th width="20%">土壤<br>有機質(%)</th>
            <th width="20%">酸鹼度<br>pH</th>
            <th width="20%">電導度(土/水=1/5)<br>μS/cm</th>
          </tr>
        </thead>
        <tbody>
          @foreach($arr_basics[$basicsKey] as $value)
            <tr>
              <td>{{ $value['depth'] }}</td>
              <td>{{ $value['water'] }}</td>
              <td>{{ $value['organic'] }}</td>
              <td>{{ $value['pH'] }}</td>
              <td>{{ $value['uScm'] }}</td>
            </tr>
          @endforeach
        </tbody>
        <thead>
          <tr>
            <th colspan="5">全部測點平均值(n=29)</th>
          </tr>
          <tr class="text-center">
            <th width="20%">土壤<br>深度(公分)</th>
            <th width="20%">土壤<br>含水率(%)</th>
            <th width="20%">土壤<br>有機質(%)</th>
            <th width="20%">酸鹼度<br>pH</th>
            <th width="20%">電導度(土/水=1/5)<br>μS/cm</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>0</td>
            <td>23.74</td>
            <td>5.9</td>
            <td>7.0</td>
            <td>127.2</td>
          </tr>
          <tr>
            <td>30</td>
            <td>17.96</td>
            <td>3.21</td>
            <td>7.5</td>
            <td>82.2</td>
          </tr>
        </tbody>
      </table>

      @if(!is_null($metal))
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>第三層</th>
              <th colspan="12">其他測值</th>
            </tr>
            <tr>
              <th>Zn</th>
              <th>Pb</th>
              <th>Cd</th>
              <th>Co</th>
              <th>Ni</th>
              <th>B</th>
              <th>Mn</th>
              <th>Fe</th>
              <th>Cr</th>
              <th>Mg</th>
              <th>Ca</th>
              <th>Cu</th>
              <th>Na</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ ($metal->Zn == "") ? "-" : $metal->Zn }}</td>
              <td>{{ ($metal->Pb == "") ? "-" : $metal->Pb }}</td>
              <td>{{ ($metal->Cd == "") ? "-" : $metal->Cd }}</td>
              <td>{{ ($metal->Co == "") ? "-" : $metal->Co }}</td>
              <td>{{ ($metal->Ni == "") ? "-" : $metal->Ni }}</td>
              <td>{{ ($metal->B == "") ? "-" : $metal->b }}</td>
              <td>{{ ($metal->Mn == "") ? "-" : $metal->Mn }}</td>
              <td>{{ ($metal->Fe == "") ? "-" : $metal->Fe }}</td>
              <td>{{ ($metal->Cr == "") ? "-" : $metal->Cr }}</td>
              <td>{{ ($metal->Mg == "") ? "-" : $metal->Mg }}</td>
              <td>{{ ($metal->Ca == "") ? "-" : $metal->Ca }}</td>
              <td>{{ ($metal->Cu == "") ? "-" : $metal->Cu }}</td>
              <td>{{ ($metal->Na == "") ? "-" : $metal->Na }}</td>
            </tr>
          </tbody>
        </table>
      @endif
      <hr>
      @endforeach

      <div class="col-12 text-center">
        <p class="text-secondary">資料新增於{{ $info->created_at }}，最後更新於{{ $info->updated_at }}</p>
      </div>
  </div>
</div>
@endsection
