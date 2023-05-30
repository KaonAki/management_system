@extends('layouts.app')

@section('content')
    <div class="search">

        {{-- ======= キーワード検索 ======= --}}
        <p class="serch_name">検索条件</p>
        <div class="serch_name search-form">
            <p class="product_name">商品名</p>
            <input id="search_name" class="search_box" type="text" name="search_name" placeholder="キーワードを入力">
            <input type="button" class="btn btn-info search-icon" name="button" value="検索">
        </div>

        {{-- ======= メーカー検索 ======= --}}
        <div class="serch_company searchCompany-form">
            <p class="company_name">メーカー名</p>
            <select class="select" name="companyId" id="company_name">
                <option value="選択">選択</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <input class="btn btn-info searchCompany-icon" type="button" name="button" value="検索">
        </div>

        {{-- ======= 価格検索 ======= --}}
        <div class="serch_price search-price-form">
            <p class="product_price">価格</p>
            <select class="select" name="price" id="product_price">
                <option value="選択">選択</option>
                @foreach ($products->unique('price') as $product)
                    <option value="{{ $product->price }}">{{ $product->price }}</option>
                @endforeach
            </select>
            <input class="btn btn-info search-price-icon" type="button" name="button" value="検索">
        </div>


        {{-- ======= 在庫検索 ======= --}}
        <div class="serch_stock search-stock-form">
            <p class="product_stock">在庫</p>
            <select class="select" name="stock" id="product_stock">
                <option value="選択">選択</option>
                @foreach ($products->unique('stock') as $product)
                    <option value="{{ $product->stock }}">{{ $product->stock }}</option>
                @endforeach
            </select>
            <input class="btn btn-info search-stock-icon" type="button" name="button" value="検索">
        </div>
    </div>


    {{-- ======= 新規登録 ======= --}}
    <div class="newjoin">
        <form method="GET" action="{{ route('newRegistration') }}">
            <button class="new_btn btn btn-warning">新規登録</button>
        </form>
    </div>


    {{-- ======= 商品一覧 ======= --}}
    <div class="main container">
        <table class="mb-3 product-group tablesorter" id="myTable">
            <thead>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>値段</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                </tr>
            </thead>
            <tbody class="product-body">
            </tbody>
        </table>
    </div>


    </div>
@endsection
