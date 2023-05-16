@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('registrationComplete') }}" enctype="multipart/form-data">
        <div class="form-group">
            @csrf
            <label for="newProductName">商品名</label>
            <input type="text" class="form-control" name="newProductName" value="{{ old('newProductName') }}">

            <p class="newCompany m-auto">メーカー名</p>
            <select class="select w-100 p-2" name="newCompanyId" placeholder="企業選択">
                <option value="選択">選択</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <br>

            <label for="newPrice">価格</label>
            <input type="price" class="form-control" name="newPrice" value="{{ old('newPrice') }}">

            <label for="newStock">在庫数</label>
            <input type="count" class="form-control" name="newStock" value="{{ old('newStock') }}">

            <label for="newComment">コメント</label>
            <input type="text" class="form-control" name="newComment" value="{{ old('newComment') }}">


            <label for="newImg">画像</label>
            <input type="file" class="form-control" name="newImage" value="{{ old('newImage') }}">

            <button type="submit" class="btn btn-success mt-3 w-100">{{ __('登録') }}</button>
        </div>
    </form>
    <div class="form-group mt-3">
        <form action="{{ route('home') }}">
            <input type="submit" class="btn btn-info w-100" name="submit" value="戻る">
        </form>
    </div>
@endsection
