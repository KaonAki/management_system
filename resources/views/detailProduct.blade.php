@extends('layouts.app')

@section('content')
    <div class="detail-container w-75 m-auto">
        <h1>詳細確認</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>商品id</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <tr>
                    <td>{{ $productId->id }}</td>
                    <td><img class="detailImage" src="{{ asset('/storage/images/' . $productId->img_path) }}"></td>
                    <td>{{ $productId->product_name }}</td>
                    <td>{{ $productId->company->company_name }}</td>
                    <td>{{ $productId->price }}</td>
                    <td>{{ $productId->stock }}</td>
                    <td>{{ $productId->comment }}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{ route('home') }}">
            <input type="submit" class="btn btn-info" name="submit" value="戻る">
        </form>

        <a href="{{ route('editProduct', $productId->id) }}">
            <input type="submit" class="btn btn-info" name="submit" value="編集">
        </a>
    </div>
@endsection
