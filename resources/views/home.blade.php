@extends('layouts.app')

@section('content')
    <div class="search">
        <p class="serch_name">検索条件</p>
        <form method="GET" action="{{ route('searchProduct') }}">
            <p class="product_name">商品名</p>
            <input class="search_box" type="search" name="search" placeholder="キーワードを入力"
                value="@if (isset($search)) {{ $search }} @endif">
            <input type="submit" class="btn btn-info" name="submit" value="検索">
        </form>

        <form method="GET" action="{{ route('selectCompany') }}">
            <p class="company_name">メーカー名</p>
            <select class="select" name="companyId">
                <option value="選択">選択</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <input class="btn btn-info" type="submit" name="submit" value="検索">
        </form>
    </div>

    <div class=" newjoin">
        <form method="GET" action="{{ route('newRegistration') }}">
            <button class="new_btn btn btn-warning">新規登録</button>
        </form>
    </div>


    <div class="main container">

        {{-- {{ dd($products) }} --}}

        @foreach ($products as $product)
            <div class="mb-3 product-group">
                <img class="col-1" src="{{ asset('/storage/images/' . $product->img_path) }}">
                <p class="me-3 col-2">{{ $product->product_name }}</p>
                <p class="me-3 col-1">¥{{ $product->price }}</p>
                <p class="me-3 col-1">在庫数:{{ $product->stock }}</p>
                <p class="me-3 col-2">メーカー:{{ $product->company->company_name }}</p>

                <a href="{{ route('detailProduct', $product->id) }}">
                    <button class="me-3 detail btn btn-success">詳細</button>
                </a>

                <td>
                    <form action="{{ route('deleteProduct', $product->id) }}" method="POST" onclick='return confirm("「{{ $product->product_name }}」を削除しますか？")'>
                        @csrf
                        <button type="submit" class="btn btn-danger ">削除</button>
                    </form>
                </td>
            </div>
        @endforeach
    </div>
@endsection
