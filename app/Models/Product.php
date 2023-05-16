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

public function __construct()
{

    
}


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

    public function  getProductId($id)
    {
        $this->id = $id;
        $products = Product::find($id);
        return $products;
    }

    // queryのやつ
    public function getSearch($search)
    {
        $query = Product::query();
        $products = $query->where('product_name', 'like', '%' . $search . '%')->get();
        return $products;
    }

    // createのやつ
    public function storeCreate($newProductName,$newPrice,$newStock,$newCompanyId,$newComment,$file_name)
    {
        Product::create([
            'img_path' => $file_name,
            'product_name' => $newProductName,
            'price' => $newPrice,
            'stock' => $newStock,
            'company_id' => $newCompanyId,
            'comment' => $newComment,
        ]);
    }

    
}