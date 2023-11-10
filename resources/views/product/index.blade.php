@extends('layouts.app')

@section('title')
    <title>Products List</title>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $product->name }}</td>

                    @switch($product->currency)
                        @case (\App\Models\Product::EURO_CURRENCY)
                            <td>€{{ $product->price }}</td>
                            @break

                        @default
                            <td>${{ $product->price }}</td>
                    @endswitch


                    <td>
                        <form method="POST" action="#"
                              id="product-form-{{ $loop->iteration }}"
                              class="d-none"
                        >
                            @csrf
                            <input type="hidden" name="product" value="{{ $product->id }}">
                        </form>

                        <button class="btn btn-primary"
                                onclick="document.getElementById('product-form-{{ $loop->iteration }}').submit()"
                        >
                            Subscribe
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('js')
@endsection


