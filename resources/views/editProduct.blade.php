@extends('layouts.app')

@section('content')
    <div>
        <form method="POST" action="{{ route('editCompleteProduct', $productModel->id) }}" enctype="multipart/form-data">
            <div class="form-group">
                @csrf
                @method('PUT')
                <label for="editProductID">商品ID:{{ $productModel->id }}</label>
                {{-- {{ dd( $productModel->id) }} --}}
                <br>

                <label for="editProductName">商品名</label>
                <input type="text" class="form-control" name="editProductName" value="{{ $productModel->product_name }}"
                    placeholder="{{ $productModel->product_name }}" required>

                <p class="newCompany m-auto">メーカー名</p>
                <select class="select" name="editCompanyId" placeholder="企業選択">
                    </option>
                    @foreach ($companies as $company)
                        @if ($company->id == $productModel->company_id)
                            <option value="{{ $productModel->company_id }}" selected>
                                {{ $productModel->company->company_name }}
                            </option>
                        @else
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endif
                    @endforeach
                </select>
                <br>

                <label for="newPrice">価格</label>
                <input type="price" class="form-control" name="editPrice" value="{{ $productModel->price }}"
                    placeholder="{{ $productModel->price }}" required>

                <label for="newStock">在庫数</label>
                <input type="count" class="form-control" name="editStock" value="{{ $productModel->stock }}"
                    placeholder="{{ $productModel->stock }}" required>

                <label for="newComment">コメント</label>
                <input type="text" class="form-control" name="editComment" value="{{ $productModel->comment }}"
                    placeholder="{{ $productModel->comment }}">


                <label for="editImg">画像</label>
                <img src="{{ asset('/storage/images/' . $productModel->img_path) }}" class="form-control">
                {{-- inputのfileで入れちゃう editImage --}}
                <input type="file" class="form-control" name="editImage">


                <button type="submit" class="btn btn-success">{{ __('登録') }}</button>

        </form>
    </div>
@endsection
