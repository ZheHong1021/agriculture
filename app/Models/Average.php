<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Average extends Model
{
    public $table = 'average';
    private static $columns = ["depth", "water", "organic", "pH", "uScm"];
    private static $chineseColumns = ["土壤深度(公分)", "土壤含水率(%)", "土壤有機質(%)", "酸鹼值(pH)", "電導度(μS/cm)"];
    protected $fillable = ["n", "depth", "water", "organic", "pH", "uScm"];
    protected $guarded = ["id", "created_at", "updated_at"];

    //取得平均測值的欄位
    public static function getColumns(){
    	return Average::$columns;
    }

    //取得平均測值的欄位
    public static function getChineseColumns(){
        return Average::$chineseColumns;
    }

    //設定欄位值條件
    public function setNAttribute($value){
    	$this->attributes['n'] = $value > 0 ? $value : 0;
    }
}
