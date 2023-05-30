<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function buyProduct($id)
    {
        $productModel = new Product();
// 商品取得
        $product = $productModel->getProductId($id);
        // dd($product);
    
        // 商品の在庫を取得
        $stock = $product->stock;

        $boughtProduct = $stock -1;
        // dd($boughtProduct);

        DB::beginTransaction();

        try {
            $product->update([
                'stock' => $boughtProduct,
            ]);
            DB::commit(); // 問題なかったからコミット
        } catch (Exception $e) {
            DB::rollback(); // 問題があったからロールバック
            ver_dump('エラー：' . $e->getMessage());
        }

        $producted = $productModel->getProductId($id);

        return response()->json($producted);

    }
}