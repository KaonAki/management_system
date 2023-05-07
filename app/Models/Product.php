<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function getList()
    {
        // テーブルからデータを取得
        $products = DB::table('products')->get();
        return $products;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    // // 更新処理
    // public function updateProduct($request, $productModel)
    // {
    //     $result = $productModel->fill([
    //         'product_name' => $request->product_name,
    //         'price'=>$request->price,
    //         'stock'=>$request->stock,
    //         'comment'=>$request->comment,
    //         'img_path'=>$request->img_path,
    //     ])->save();

    //     return $result;
    // }
}
