@extends('layouts.app')

@section('title')
    <title>Create Product</title>
@endsection

@section('content')
    <form action="{{ route('products.store') }}" method="POST"
        class="d-flex flex-column justify-content-center align-items-center"
    >
        @csrf
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" id="productName" placeholder="Ex: T-shirt">
        </div>

        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price</label>
            <input type="text" class="form-control" name="price" id="productPrice" placeholder="Ex: 15.25">
        </div>

        <select class="form-select mb-3" name="currency" aria-label="currency selection">
            <option selected>Open this menu</option>

            @foreach(\App\Models\Product::CURRENCIES_MAP as $key => $currency)
                <option value="{{ $key }}">{{ $currency }}</option>
            @endforeach
        </select>

        <div class="">
            <button type="submit" class="btn btn-primary mb-3">Add product</button>
        </div>
    </form>
@endsection

@section('js')
@endsection


