<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    //  商品一覧表示
    public function index()
    {
        
        // インスタンス生成
        $model = new Company();
        $companies = $model->getList();
        // dd($companies);

        $productModel = new Product();
        $products = $productModel->getList();
        // companyとproductの結合
        $productCompanyId = $productModel->getProduct();
        // dd($productCompanyId);

        return view('home', compact('companies', 'productCompanyId', 'products'));
    }

    public function indexView()
    {
    $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        $products = $productModel->getProduct();
        return response()->json($products);
    }

    // キーワード検索
    public function searchProduct(Request $request)
    {
        $model = new Company();
        $companies = $model->getList();

        // 検索フォームで入力された値を取得する
        $search = $request->input('search_name');

        $productModel = new Product();
        $productCompanyId = $productModel->getSearch($search);
        // dd($search);

        return view('home', compact('companies', 'productCompanyId'));
    }

    // メーカー選択検索
    public function selectCompany(Request $request)
    {
        $model = new Company();
        $companies = $model->getList();

        $companyId = $request->input('companyId');
        // dd($company);

        // クエリビルダ プロダクトテーブル内でSQLを使ってデータの取得をしたい時
        $query = Product::query();

        $products = $query->where('company_id', $companyId)->get();
        // dd($products);

        return view('home', compact('companies', 'products'));
    }

    // 新規登録画面にいきたい
    public function newRegistration()
    {
        $model = new Company();
        $companies = $model->getList();

        return view('newProduct', compact('companies'));
    }

    // 新規登録完了
    public function registrationComplete(Request $request)
    {
        $request->validate(
            [
                'newProductName' => 'required',
                'newPrice' => 'required|integer',
                'newStock' => 'required|integer',
                'newComment' => 'required',
                'newImage' => 'required',
                'newCompanyId' => 'required',
            ],
            [
                'newProductName.required' => '商品名を入力してください',
                'newPrice.integer' => '整数を入力してください',
                'newPrice.required' => '価格を入力してください',
                'newStock.integer' => '整数を入力してください',
                'newStock.required' => '在庫数を入力してください',
                'newComment.required' => 'コメントを入力してください',
                'newImage.required' => '画像を添付して下さい',
                'newCompanyId.required' => 'メーカーを選択して下さい',
            ],
        );

        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        // companyとproductの結合
        $productCompanyId = $productModel->company();

        //
        $newProductName = $request->input('newProductName');
        $newPrice = $request->input('newPrice');
        $newStock = $request->input('newStock');
        $newCompanyId = $request->input('newCompanyId');
        $newComment = $request->input('newComment');
        // dd($request);

        $newImage = $request->file('newImage');
        // アップロードされたファイル名を取得
        $file_name = $newImage->getClientOriginalName();
        // 保存
        $newImage->storeAs('public/images', $file_name);

        // トランザクション処理開始
        DB::beginTransaction();

        try {
            $productCreate = $productModel->storeCreate($newProductName, $newPrice, $newStock, $newCompanyId, $newComment, $file_name);

            DB::commit(); // 問題なかったからコミット
        } catch (Exception $e) {
            DB::rollback(); // 問題があったからロールバック
            ver_dump('エラー：' . $e->getMessage());
        }

        return redirect()->route('home', compact('companies'));
    }

    // 詳細表示
    public function detailProduct($id)
    {
        $productModel = new Product();
        // companyとproductの結合
        $productCompanyId = $productModel->company();
        $productId = $productModel->getProductId($id);

        return view('detailProduct', compact('productCompanyId', 'productId'));
    }

    // 編集画面
    public function editProduct(Request $request, $id)
    {
        $productModel = new Product();
        // companyとproductの結合
        $productCompanyId = $productModel->company();
        $productId = $productModel->getProductId($id);
        // dd($productId);

        $companyModel = new Company();
        $companyId = $companyModel->getCompanyId($id);
        // dd($companyId);
        $companies = $companyModel->getList();
        // dd($companies);

        return view('editProduct', compact('productCompanyId', 'productId', 'companyId', 'companies'));
    }

    // 編集実行
    public function editCompleteProduct(Request $request, $id)
    {
        $request->validate(
            [
                'editProductName' => 'required',
                'newComment' => 'required',
                'editPrice' => 'required|integer',
                'editStock' => 'required|integer',
                'newImage' => 'required',
                'editCompanyId' => 'required',
            ],
            [
                'editProductName.required' => '商品名を入力してください',
                'editCompanyId.required' => 'メーカーを選択して下さい',
                'editPrice.integer' => '整数を入力してください',
                'editPrice.required' => '価格を入力してください',
                'editStock.integer' => '整数を入力してください',
                'editStock.required' => '在庫数を入力してください',
                'editComment.required' => 'コメントを入力してください',
                'editImage.required' => '画像を添付して下さい',
            ],
        );

        $productModel = new Product();
        // companyとproductの結合
        $productCompanyId = $productModel->company();
        $productId = $productModel->getProductId($id);
        // dd($productId);

        $companyModel = new Company();
        $companyId = $companyModel->getCompanyId($id);
        // dd($companyId);
        $companies = $companyModel->getList();
        // dd($companies);

        //画像に対しての全てを取得
        $editImage = $request->file('editImage');
        // 上記のなかの画像名だけを取得
        $file_name = $editImage->getClientOriginalName();
        // dd($file_name);

        // 保存
        $editImage->storeAs('public/images', $file_name);

        // dd($request);

        // トランザクション処理開始
        DB::beginTransaction();

        try {
            $productModel->update([
                'product_name' => $request->editProductName,
                'price' => $request->editPrice,
                'stock' => $request->editStock,
                'comment' => $request->editComment,
                'img_path' => $file_name,
                'company_id' => $request->editCompanyId,
            ]);
            DB::commit(); // 問題なかったからコミット
        } catch (Exception $e) {
            DB::rollback(); // 問題があったからロールバック
            ver_dump('エラー：' . $e->getMessage());
        }

        return redirect()->route('home', compact('productCompanyId', 'productId', 'companyId', 'companies'));
    }

    // 削除完了
    public function deleteProduct($id)
    {
        // インスタンス生成
        $productModel = new Product();
        // 指定のIDのレコード1件を取得
        $products = $productModel->getProductId($id);

        // トランザクション処理開始
        DB::beginTransaction();

        try {
            // レコードを削除
            $products->delete();
            // 削除したら一覧画面にリダイレクト
            DB::commit(); // 問題なかったからコミット
        } catch (Exception $e) {
            ver_dump('エラー：' . $e->getMessage());
            DB::rollback(); // 問題があったからロールバック
        }
    }

    // ajaxの検索フォーム
    public function productSearchName($id)
    {
        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        $products = $productModel->getAjaxSearch($id);

        return response()->json($products);
    }

    // ajaxのメーカー検索フォーム
    public function companySearchName($id)
    {
        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        $products = $productModel->getCompanySearch($id);

        return response()->json($products);
    }

    // ajaxの価格検索フォーム
    public function productSearchPrice($price)
    {
        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        $products = $productModel->getProductPrice($price);

        return response()->json($products);
    }

    // ajaxの在庫検索フォーム
    public function productSearchStock($stock)
    {
        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        $products = $productModel->getProductStock($stock);
        return response()->json($products);
    }
    
}