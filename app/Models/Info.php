<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
	private static $columns = ["no", "name", "species", "method", "name", "lat", "lng"];
    protected $fillable = ["no", "name", "species", "method", "name", "lat", "lng"];
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $appends = ['link'];

    public function Basics(){
    	return $this->hasMany('App\Basics')->orderBy('id', 'ASC');
    }
    public function metal(){
    	return $this->hasMany('App\Metal');
    }

    //取得基本資料的欄位
    public static function getColumns(){
    	return Info::$columns;
    }

    public function getLinkAttribute(){
        $index = Info::where('id', '<=', $this->id)->count();
        $pageNumber = ceil($index / 4);
        return route('home.index')."/?page=$pageNumber";
    }
}
