<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basics extends Model
{
    use HasFactory;

    public $table = 'basics';
	public $timestamps = false;
	private static $columns = ["depth", "water", "organic", "pH", "uScm"];
    private static $chineseColumns = ["土壤深度(公分)", "土壤含水率(%)", "土壤有機質(%)", "酸鹼值(pH)", "電導度(μS/cm)"];
    protected $fillable = ["depth", "water", "organic", "pH", "uScm"];
    protected $guarded = ["id", "info_id"];

    public function owner(){
    	return $this->belongsTo('App\Info', 'info_id');
    }

    //取得基本測值的欄位
    public static function getColumns(){
    	return Basics::$columns;
    }

    //取得基本測值的欄位
    public static function getChineseColumns(){
        return Basics::$chineseColumns;
    }

}
