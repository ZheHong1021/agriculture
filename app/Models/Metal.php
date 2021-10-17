<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metal extends Model
{	
	public $table = 'metal';
	public $timestamps = false;
	private static $columns = ["Zn", "Pb", "Cd", "Co", "Ni", "B" , "Mn", "Fe", "Cr", "Mg", "Ca", "Cu", "Na"];
    private static $chineseColumns = ["鋅", "鉛", "鎘", "鈷", "鎳", "硼" , "錳", "鐵", "鉻", "鎂", "鈣", "銅", "鈉"];
    protected $fillable = ["Zn", "Pb", "Cd", "Co", "Ni", "B" , "Mn", "Fe", "Cr", "Mg", "Ca", "Cu", "Na"];
    protected $guarded = ["id", "info_id"];

    public function owner(){
    	return $this->belongsTo('App\Info', 'info_id');
    }

    //取得金屬測值的欄位
    public static function getColumns(){
    	return Metal::$columns;
    }

    //取得金屬測值的中文欄位
    public static function getChineseColumns(){
        return Metal::$chineseColumns;
    }
}
