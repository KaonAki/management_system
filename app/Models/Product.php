<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory;
    use Sortable;

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
        $productModel = Product::query();
        $products = $productModel->where('product_name', 'like', '%' . $search . '%')->get();
        // dd($products);
        return $products;
    }

    public function getAjaxSearch($search)
    {
        $intoTheJoin = DB::table('companies')
        ->join('products', 'companies.id', '=', 'products.company_id')
        ->where('product_name', 'like', '%' . $search . '%')
        ->get();
        // dd($products);
        return $intoTheJoin;
    }

    public function getCompanySearch($search)
    {
        // dd($search);
        $intoTheJoin = DB::table('companies')
        ->join('products', 'companies.id', '=', 'products.company_id')
        ->where('company_id', $search)
        ->get();
        return $intoTheJoin;
    }

    // ajax一覧表示
    public function getProduct()
    {
        $intoTheJoin = DB::table('companies')
        ->join('products', 'companies.id', '=', 'products.company_id')
        ->get();
        // dd($intoTheJoin);
        return $intoTheJoin;
    }

    // ajaxの価格検索フォーム
    public function getProductPrice($search)
    {
        // dd($search);
        $intoTheJoin = DB::table('companies')
        ->join('products', 'companies.id', '=', 'products.company_id')
        ->where('price', $search)
        ->get();
        return $intoTheJoin;
    }

    // ajaxの価格検索フォーム
    public function getProductStock($search)
    {
        // dd($search);
        $intoTheJoin = DB::table('companies')
        ->join('products', 'companies.id', '=', 'products.company_id')
        ->where('stock', $search)
        ->get();
        return $intoTheJoin;
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

    // sortの価格順
    public function orderPrice($select){
        if($select == 'asc'){
            // dd(Product::orderBy('price', 'asc')->get());
            return Product::orderBy('price', 'asc')->get();
            
        } elseif($select == 'desc') {
            return Product::orderBy('price', 'desc')->get();
        } else {
            return $this->all();
        }
    }

    // sortの在庫順
    public function orderStock($select){
        if($select == 'asc'){
            return Product::orderBy('stock', 'asc')->get();
            
        } elseif($select == 'desc') {
            return Product::orderBy('stock', 'desc')->get();
        } else {
            return $this->all();
        }
    }

    
}