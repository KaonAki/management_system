<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //  商品一覧表示
    public function index()
    {
        // インスタンス生成
        $model = new Company();
        $companies = $model->getList();
        // dd($companies);

        $productModel = new Product();
        // 全部の値取得
        $products = $productModel->all();
        // dd($products);

        return view('home', compact('companies', 'products'));
    }


    // キーワード検索
    public function searchProduct(Request $request)
    {

        $model = new Company();
        $companies = $model->getList();

        // 検索フォームで入力された値を取得する
        $search = $request->input('search');
        // dd($search);

        // クエリビルダ プロダクトテーブル内でSQLを使ってデータの取得をしたい時
        $query = Product::query();

        // もし検索フォームにキーワードが入力されたら
        // if ($search) {

        // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
        $products = $query->where('product_name', 'like', '%' . $search . '%')->get();
        // dd($products);
        // }

        return view('home', compact('companies', 'products'));
        // return redirect('/')->with(compact('products'));
    }

    // メーカー選択検索
    public function selectCompany(Request $request){

        $model = new Company();
        $companies = $model->getList();

        // メーカー選択検索
        $companyId = $request->input('companyId');
        // dd($company);

        // クエリビルダ プロダクトテーブル内でSQLを使ってデータの取得をしたい時
        $query = Product::query();

        $products = $query->where('company_id',$companyId)->get();
        // dd($products);

        return view('home', compact('companies', 'products'));
    }

    // 新規登録画面にいきたい
    public function newRegistration(){

        $model = new Company();
        $companies = $model->getList();

        return view('newProduct',compact('companies'));
    }


    // 新規登録完了
    public function registrationComplete(Request $request)
    {
        $model = new Company();
        $companies = $model->getList();

        $productModel = new Product();
        // 全部の値取得
        $products = $productModel->all();


        

        // アップロードされたファイル名を取得
        $newImage = $request->file('newImage');

        
        $file_name = $newImage->getClientOriginalName();

        // 保存
        $newImage->storeAs('public/images', $file_name);

        

        // 
        $newProductName = $request->input('newProductName');
        $newPrice = $request->input('newPrice');
        $newStock = $request->input('newStock');
        $newCompanyId = $request->input('newCompanyId');
        $newComment = $request->input('newComment');
        // dd($request);

        Product::create([
            'img_path'=>$file_name,
            'product_name' =>$newProductName,
            'price' =>$newPrice ,
            'stock' => $newStock,
            'company_id' => $newCompanyId,
            'comment' => $newComment
        ]);


        return redirect()->route('home', compact('companies', 'products'));
    }


    // 詳細表示
    public function detailProduct($id)
    {
        $model =Company::find($id);
        $productModel = Product::find($id);
        
        return view('detailProduct', compact('model','productModel'));
    }
    

    // 編集画面
    public function editProduct(Request $request ,$id)
    {
        $model =Company::find($id);
        $productModel = Product::find($id);

        $editCompany = new Company();
        $companies = $editCompany->getList();

        $editProduct = new Product();
        // 全部の値取得
        $products = $editProduct->all();

        
        return view('editProduct',compact('companies','products','model','productModel'));
    }

    // 編集完了
    public function editCompleteProduct(Request $request ,$id)
    {
        // $model =Company::find($id);
        $productModel = Product::find($id);

        // dd($request);

        $productModel->update([  
            "product_name" => $request->editProductName,  
            "price" => $request->editPrice,  
            "stock" => $request->editStock,  
            "comment" => $request->editComment,  
            "img_path" => $request->editImage,  
            'company_id' => $request->editCompanyId
        ]);  

        return redirect()->route('home', compact( 'productModel'));
    }

    // 削除完了
    public function deleteProduct($id)
    {
        // 指定のIDのレコード1件を取得
        $productModel = Product::find($id);

        // レコードを削除
        $productModel->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect()->route('home', compact( 'productModel'));
    }

}
