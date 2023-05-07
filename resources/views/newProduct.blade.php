@extends('layouts.app')

@section('content')


        <form method="POST" action="{{ route('registrationComplete') }}" enctype="multipart/form-data">
            <div class="form-group">
                @csrf
                <label for="newProductName">商品名</label>
                <input type="text" class="form-control" name="newProductName" id="book_name">
                
                <p class="newCompany m-auto">メーカー名</p>
                <select class="select" name="newCompanyId" placeholder="企業選択">
                    <option value="選択">選択</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name}}</option>
                    @endforeach
                </select>
                <br>

                <label for="newPrice">価格</label>
                <input type="price" class="form-control" name="newPrice" id="book_name">
                
                <label for="newStock">在庫数</label>
                <input type="count" class="form-control" name="newStock" id="book_name">

                <label for="newComment">コメント</label>
                <input type="text" class="form-control" name="newComment" id="book_name">
                

                <label for="newImg">画像</label>
                <input type="file" class="form-control" name="newImage" id="book_name">
                
                <button type="submit" class="btn btn-success">{{ __('登録') }}</button>
                
        </form>

        <form action="{{ route('home') }}">
            <input type="submit" class="btn btn-info" name="submit" value="戻る">
        </form>

@endsection
