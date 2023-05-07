<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

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

    // // 更新処理
    // public function updateCompany($request, $model)
    // {
    //     $result = $model->fill([
    //         'company_name' => $request->company_name,
    //     ])->save();

    //     return $result;
    // }
}