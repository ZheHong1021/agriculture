<?php
/*
|--------------------------------------------------------------------------
| ReadController
|--------------------------------------------------------------------------
|
| 負責系統首頁檢測報告的讀取
*/

namespace App\Http\Controllers;
use App\Models\Info;
use App\Models\Metal;
use App\Models\Basics;
use App\Models\Average;
use Auth;

class ReadController extends Controller
{
    public function __construct()
	{
	    //$this->middleware('auth');
	}

	public function index(){

		$info = Info::paginate(4);
		$metalColumns = Metal::getColumns();

		//計算頁數
		if($info->lastPage() < $info->currentPage()){
			abort(404,'頁面不存在');
			exit;
		}
		if($info->lastPage() <= 4){
			$startPage = 1;
			$endPage = $info->lastPage();
		}else{
			$startPage = $info->currentPage();
			$endPage = $info->currentPage() + 3;
			if($endPage > $info->lastPage() ){
				$endPage = $info->lastPage();
			}
		}
		//補齊不足的頁數
		if(($endPage - $startPage) != 3){
			$startPage -= (3-($endPage - $startPage));
		}

		return view('reports.index',['info' => $info, 'metalColumns' => $metalColumns, 'startPage' => $startPage, 'endPage' => $endPage]);
	}

	public function getReportById($info_id){

		//判斷是否有傳遞id
		if(empty($info_id)){
    		$status["code"] = "400";
    		$status["status"] = "資料編號無效";
    		$data = array();
    		$response = array();
    		$response["status"] = $status;
    		$response["data"] = $data;
    		return response(json_encode($response), $status["code"])
           		->header('Content-Type', 'application/json');
		}

		//判斷是否有資料
		$info = Info::find($info_id);
		if(empty($info)){
			$status["code"] = "404";
    		$status["status"] = "資料不存在";
    		$data = array();
    		$response = array();
    		$response["status"] = $status;
    		$response["data"] = $data;
    		return response(json_encode($response), $status["code"])
           		->header('Content-Type', 'application/json');
		}

		$basics = $info->basics;
		$average = Average::all();

		//一般訪客看不到第三層
		if( Auth::user()->isGuest() ){
			$metal = array();
			$metalColumns = array();
		}else{
			$metal = $info->metal;
			$metalColumns = Metal::getColumns();
		}

		$status["code"] = "200";
		$status["status"] = "請求成功";

		$data["info"] = $info;
		$data["basics"] = $basics;
		$data["average"] = $average;
		$data["metal"] = $metal;
		$data["basicsColumns"] = Basics::getColumns();
		$data["metalColumns"] = $metalColumns;

		$response = array();
		$response["status"] = $status;
		$response["data"] = $data;
		return response(json_encode($response), $status["code"])
       		->header('Content-Type', 'application/json');
	}

	public function getReport(){

		$info = Info::all();
		$status["code"] = "200";
		$status["status"] = "請求成功";
		$data["info"] = $info;
		$response = array();
		$response["status"] = $status;
		$response["data"] = $data;
		return response(json_encode($response), $status["code"])
       		->header('Content-Type', 'application/json');
	}
}
