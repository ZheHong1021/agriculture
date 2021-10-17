<?php
/*
|--------------------------------------------------------------------------
| ReportController
|--------------------------------------------------------------------------
|
| 負責檢測報告的新增/讀取/刪除/修改
*/

namespace App\Http\Controllers;

use Auth;
use Session;
use Storage;
use DB;
use Gate;
use App\Models\Info;
use App\Models\Metal;
use App\Models\Basics;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Session as FacadesSession;

class ReportController extends Controller
{
    public function __construct()
	{
	    
	}

	public function index(){		

		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			$info = Info::orderBy('no', 'ASC')->paginate(10);
			return view('admin.reports.index',['info' => $info]);
		}else{
			abort(403);
		}

	}

	public function create(){
		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			$reportCount = Info::all()->count();
			return view('admin.reports.create', ['reportCount' => $reportCount, 'basicsColumns' => Basics::getColumns(), 'basicsChineseColumns' => Basics::getChineseColumns(), "metalColumns" => Metal::getColumns(), "metalChineseColumns" => Metal::getChineseColumns()]);
		}else{
			abort(403);
		}

		$reportCount = Info::all()->count();
		return view('admin.reports.create', ['reportCount' => $reportCount, 'basicsColumns' => Basics::getColumns(), 'basicsChineseColumns' => Basics::getChineseColumns(), "metalColumns" => Metal::getColumns(), "metalChineseColumns" => Metal::getChineseColumns()]);
	}

	public function store(Request $request){
		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){

		$input = $request->all();
		$basicsColumns = Basics::getColumns();
		$metalColumns = Metal::getColumns();

		//基本資料的規則
    	$rules = ['no' => 'required|numeric', 'name' => 'required', 'species' => 'required|String', 'method' => 'required|String', 'lng' => 'required|numeric', 'lat' => 'required|numeric'];

		//基本測值的規則
		foreach ($basicsColumns  as $basicsColumn) {
			$rules["basics.*.$basicsColumn"] = 'numeric|nullable';
		}

    	//金屬資料的規則
    	foreach ($metalColumns as $metalColumn) {
			$rules["metal.*.$metalColumn"] = 'numeric|nullable';
		}
		

		//驗證結果
	    $validator = Validator::make($input, $rules);
	    if(!$validator->passes()){

			if($validator->errors()->has("basics.*")){
				$validator->errors()->add('basics', '請輸入正確格式的基本測值(數字)');	
			}

			if($validator->errors()->has("metal.*")){
				$validator->errors()->add('metal', '請輸入正確格式的金屬測值(數字)');	
			}
	    	
	    	return redirect()->route('admin.report.create')->withInput()->withErrors($validator);	    	
	    }

	    //開始新增資料
	    FacadesDB::beginTransaction();
	    try {
	    	//基本資料
	    	$info = new Info();
	    	$info->no = $request->input('no');
	    	$info->name = $request->input('name');
	    	$info->species = $request->input('species');
	    	$info->method = $request->input('method');
	    	$info->lng = $request->input('lng');
	    	$info->lat = $request->input('lat');
	    	$info->save();

	    	//基本測值
	    	for($i = 0 ; $i < 2 ; $i ++){
	    		$basics = new Basics();
	    		foreach ($basicsColumns as $basicsColumn) {
	    			$basics->$basicsColumn = $request->input("basics.$i.$basicsColumn");
	    		}
	    		$basics->info_id = $info->id;
	    		$basics->save();	    		
	    	}

	    	//金屬測值
	    	for($i = 0 ; $i < 2 ; $i ++){
		    	$metal = new Metal();
				foreach ($metalColumns as $metalColumn) {
					$metal->$metalColumn = $request->input("metal.$i.$metalColumn");
				}
				$metal->info_id = $info->id;
				$metal->save();
			}

			FacadesDB::commit();
			FacadesSession::flash('successMessage', '新增成功');
	    } catch (Exception $e) {
	    	FacadesDB::rollback();
	    	FacadesSession::flash('errorMessage', '新增失敗，請稍後再試或聯絡網站管理員');
	    }
    	
    	return redirect()->route('admin.report.index');

		}else{
			abort(403);
		}

		
	}
	public function edit($id){
		
		//找不到的話會拋出404
		$info = Info::findOrFail($id);

		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			$reportCount = Info::all()->count(); // 29
			// $basics = $info->basics;
			// $metal = $info->metal;
			$basics = Basics::where('info_id', $id)->get();
			$metal = Metal::where('info_id', $id)->get();
			// dd($basics);
			return view('admin.reports.edit',[
				'info' => $info, 
				'reportCount' => $reportCount, 
				'basicsColumns' => Basics::getColumns(), 
				'basicsChineseColumns' => Basics::getChineseColumns(), 
				"metalColumns" => Metal::getColumns(), 
				"metalChineseColumns" => Metal::getChineseColumns(), 
				'basics' => $basics, 
				'metal' => $metal]);
		}else{
			abort(403);
		}

	}
	public function update($id, Request $request){
		//找不到的話會拋出404
		$info = Info::findOrFail($id);
		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			$input = $request->all();
			$basicsColumns = Basics::getColumns();
			$metalColumns = Metal::getColumns();

			//基本資料的規則
			$rules = [
				'no' => 'required|numeric', 
				'name' => 'required', 
				'species' => 'required|String', 
				'method' => 'required|String', 
				'lng' => 'required|numeric', 
				'lat' => 'required|numeric'];

			//基本測值的規則
			foreach ($basicsColumns  as $basicsColumn) {
				$rules["basics.*.$basicsColumn"] = 'numeric|nullable';
			}

			//金屬資料的規則
			foreach ($metalColumns as $metalColumn) {
				$rules["metal.*.$metalColumn"] = 'numeric|nullable';
			}

			//驗證結果
			$validator = Validator::make($input, $rules);
			if(!$validator->passes()){
				if($validator->errors()->has("basics.*")){
					$validator->errors()->add('basics', '請輸入正確格式的基本測值(數字)');	
				}

				if($validator->errors()->has("metal.*")){
					$validator->errors()->add('metal', '請輸入正確格式的金屬測值(數字)');	
				}
				
				return redirect()->route('admin.report.edit', ["id" => $id])->withInput()->withErrors($validator);
			}

			//開始更新資料
			FacadesDB::beginTransaction();
			try {
				//更新info資料
				$info->no = $request->input('no');
				$info->name = $request->input('name');
				$info->species = $request->input('species');
				$info->method = $request->input('method');
				$info->lng = $request->input('lng');
				$info->lat = $request->input('lat');
				$info->save();
				$info->touch();

				//移除舊的測值
				// $basics = $info->Basics;
				// $metal = $info->metal;
				$basics = Basics::where('info_id', $id)->get();
				$metal = Metal::where('info_id', $id)->get();
				foreach ($basics as $b) {
					$b->delete();
				}
				foreach ($metal as $m) {
					$m->delete();
				}

				//基本測值
				for($i = 0 ; $i < 2 ; $i ++){
					$basics = new Basics();
					foreach ($basicsColumns as $basicsColumn) {
						$basics->$basicsColumn = $request->input("basics.$i.$basicsColumn");
					}
					$basics->info_id = $info->id;
					$basics->save();	    		
				}

				//金屬測值
				for($i = 0 ; $i < 2 ; $i ++){
					$metal = new Metal();
					foreach ($metalColumns as $metalColumn) {
						$metal->$metalColumn = $request->input("metal.$i.$metalColumn");
					}
					$metal->info_id = $info->id;
					$metal->save();
				}

				FacadesDB::commit();
				FacadesSession::flash('successMessage', '點位#'.$info->no.' 修改成功');
			} catch (Exception $e) {
				FacadesDB::rollback();
				FacadesSession::flash('errorMessage', '點位#'.$info->no.' 修改失敗，請稍後再試或聯絡網站管理員');
			}
				
			return redirect()->route('admin.report.index');
		}else{
			abort(403);
		}
	    	
	}
	public function destroy($id){
		
		//找不到的話會拋出404
		$info = Info::findOrFail($id);

		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			//開始刪除資料
			FacadesDB::beginTransaction();
			try {
				//移除舊的測值
				// $basics = $info->Basics;
				// $metal = $info->metal;
				$basics = Basics::where('info_id', $id)->get();
				$metal = Metal::where('info_id', $id)->get();
				foreach ($basics as $b) {
					$b->delete();
				}
				foreach ($metal as $m) {
					$m->delete();
				}
				$info->delete();
	
				FacadesDB::commit();
				FacadesSession::flash('successMessage', ' 刪除成功');
			}catch(Exception $e){
				FacadesDB::rollback();
				FacadesSession::flash('errorMessage', '刪除失敗，請稍後再試或聯絡網站管理員');
			}
			return redirect()->route('admin.report.index');
		}else{
			abort(403);
		}

		
	}

	public function upload(){
		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			return view('admin.reports.upload');
		}
	}

	public function storeFile(Request $request){
		//權限判斷
		if(FacadesGate::allows('manage-report', Info::class)){
			$input = $request->all();
			$rules = ["file" => "required"];

			//驗證是否有上傳檔案
			$validator = Validator::make($input, $rules);
			if(!$validator->passes()){
				return redirect()->route('admin.report.upload')->withErrors($validator);
			}

			if($request->hasFile('file')){
				$extension = $request->file('file')->getClientOriginalExtension();
				if($extension != "csv"){
					//驗證csv
					$validator->errors()->add('file', '請上傳格式正確的檔案(csv)');
					return redirect('admin/report/upload')->withErrors($validator);
					exit;
				}

				$path = $request->file('file')->getRealPath();
				$csv = array_map('str_getcsv', file($path));
				$infoHeader = array_slice($csv[0], 0, 6);
				$basicsHeader = array_slice($csv[0], 6, 5);
				$data = array_slice($csv, 1);
				$arr_info = array();
				$arr_metal = array();
				//print_r($data);

				//資料整理
				for($x = 0 ; $x < count($data) ; $x++){
					$tmp_infoValue = array_slice($data[$x], 0, 6);
					$tmp_basicsValue = array_slice($data[$x], 6, 5);
					$tmp_info = array();

					//info 資料格式整理
					for($i = 0 ; $i < count($infoHeader) ; $i++){
						$column = $infoHeader[$i];
						$value = $tmp_infoValue[$i];
						$tmp_info[$column] = $value;
					}
					$arr_info[$x] = $tmp_info;

					//basics 資料格式整理
					for($i = 0 ; $i < count($basicsHeader) ; $i++){
						$column = $basicsHeader[$i];
						$value = $tmp_basicsValue[$i];
						$tmp_basics[$column] = $value;
					}
					$arr_basics[$x] = $tmp_basics;
				}

				$beforeNo = "";
				$beforeId = "";
				$infoColumns = Info::getColumns();
				$basicsColumns = Basics::getColumns();
				$metalColumns = Metal::getColumns();
				$count = 0;

				//開始匯入資料
				FacadesDB::beginTransaction();
				try {
					for($i = 0 ; $i < count($arr_info) ; $i ++){
						if($arr_info[$i]['no'] != $beforeNo){
							//基本資料
							$info = new Info();
							foreach ($infoColumns as $column) {
								$info->$column = $arr_info[$i][$column];
							}
							$info->save();
							$beforeNo = $arr_info[$i]['no'];
							$beforeId = $info->id;
							$count += 1;
						}

						//基本測值
						$basics = new Basics();
						foreach ($basicsColumns as $column) {
							$basics->$column = $arr_basics[$i][$column];
						}
						$basics->info_id = $beforeId;
						$basics->save();

						//金屬測值
						$metal = new Metal();
						foreach ($metalColumns as $column) {
							$metal->$column = NULL;
						}
						$metal->info_id = $info->id;
						$metal->save();
					}

					FacadesDB::commit();
					FacadesSession::flash('successMessage', '匯入資料成功，共'.$count.'筆');
				}catch(Exception $e){
					FacadesDB::rollback();
					FacadesSession::flash('errorsMessage', '匯入資料失敗，請稍後再試或是聯絡網站管理員');
				}
				return redirect()->route('admin.report.index');
			}
		}else{
			abort(403);
		}
	}
}
