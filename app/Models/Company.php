<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = [
        'created_at',	
        'updated_at'	
    ];

    public function getList() {
        // articlesテーブルからデータを取得
        $companies = DB::table('companies')->get();
        return $companies;
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function  getCompanyId($id)
    {
        $this->id = $id;
        $companies = Company::find($id);
        return $companies;
    }
}