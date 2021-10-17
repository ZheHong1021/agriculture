<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Average;
use Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class AverageController extends Controller
{
    public function __construct()
	{
	    //$this->middleware('auth');

	    //權限檢查
	    //$this->middleware('authorityCheck');
	}

	public function index(){
		$average = Average::all();
		$averageColumns = Average::getColumns();
		$averageCineseColumns = Average::getChineseColumns();
		$infoCount = Info::all()->count();

		//判斷是否有平均值資料
		if(count($average) <= 0){
			return view('admin.reports.average.create', ['averageColumns' => $averageColumns, 'averageChineseColumns' => $averageChineseColumns, 'infoCount' => $infoCount]);
		}else{
			return view('admin.reports.average.edit', ['average' => $average, 'averageColumns' => $averageColumns, 'averageChineseColumns' => $averageCineseColumns, 'infoCount' => $infoCount]);
		}
	}

	public function store(Request $request){
		$input = $request->all();
		$averageColumns = Average::getColumns();

		//平均值測值的規則
		foreach ($averageColumns  as $averageColumn) {
    		$rules["average.*.$averageColumn"] = 'required|numeric';
    	}
    	$rules['n'] = 'required|numeric';

    	//驗證結果
	    $validator = Validator::make($input, $rules);
	    if(!$validator->passes()){

			if($validator->errors()->has('average.*')){
				$validator->errors()->add('average', '請輸入正確格式的測點平均值(數字)');	
			}

	    	return redirect()->route('admin.report.average.index')->withInput()->withErrors($validator);	    	
	    }

	    //開始更新
	    DB::beginTransaction();
	    try {
	    	//先移除舊的平均值資料
		    Average::truncate();

		    //新增平均值資料
		    for($i = 0 ; $i < 2 ; $i++){
		    	$average = new Average();
		    	$average->n = $request->input('n');
			    foreach ($averageColumns as $averageColumn) {
			    	$average->$averageColumn = $request->input("average.$i.$averageColumn");
			    }
			    $average->save();
		    }
	    
		    DB::commit();
	    	Session::flash('successMessage', '測點平均值更新成功');
	    } catch (Exception $e) {
	    	DB::rollback();
	    	Session::flash('errorMessage', '測點平均值更新失敗，請稍後再試或是聯絡網站管理員');
	    }	
    	return redirect()->route('admin.report.index');
	}
}
