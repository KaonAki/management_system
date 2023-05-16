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
    <div>
        <form method="POST" action="{{ route('editCompleteProduct', $productId->id) }}" enctype="multipart/form-data">
            <div class="form-group">
                @csrf
                @method('PUT')
                <label for="editProductID">商品ID:{{ $productId->id }}</label>
                {{-- {{ dd( $productModel->id) }} --}}
                <br>

                <label for="editProductName">商品名</label>
                <input type="text" class="form-control" name="editProductName" value="{{ $productId->product_name }}"
                    placeholder="{{ $productId->product_name }}">

                <p class="newCompany m-auto">メーカー名</p>
                <select class="select" name="editCompanyId" placeholder="企業選択">
                    </option>
                    @foreach ($companies as $company)
                        @if ($company->id == $productId->company_id)
                            <option value="{{ $productId->company_id }}" selected>
                                {{ $companyId->company_name }}
                            </option>
                        @else
                            <option value="{{ $companyId->id }}">{{ $company->company_name }}</option>
                        @endif
                    @endforeach
                </select>
                <br>

                <label for="newPrice">価格</label>
                <input type="price" class="form-control" name="editPrice" value="{{ $productId->price }}"
                    placeholder="{{ $productId->price }}">

                <label for="newStock">在庫数</label>
                <input type="count" class="form-control" name="editStock" value="{{ $productId->stock }}"
                    placeholder="{{ $productId->stock }}">

                <label for="newComment">コメント</label>
                <input type="text" class="form-control" name="editComment" value="{{ $productId->comment }}"
                    placeholder="{{ $productId->comment }}">


                <label for="editImg">画像</label>
                <img src="{{ asset('/storage/images/' . $productId->img_path) }}" class="form-control">
                {{-- inputのfileで入れちゃう editImage --}}
                <input type="file" class="form-control" name="editImage">


                <button type="submit" class="btn btn-success">{{ __('登録') }}</button>

        </form>
    </div>
@endsection
