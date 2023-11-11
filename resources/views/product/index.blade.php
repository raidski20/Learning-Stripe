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
                        <button class="btn btn-primary"
                                onclick="checkout('{{ $product->stripe_price }}')"
                        >
                            Subscribe
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('stripe.payment.checkout') }}"
          id="product_form"
          class="d-none"
    >
        @csrf
        <input type="hidden" id="product_id" name="product_id" value="">
    </form>
@endsection

@section('js')
    <script>
        function checkout(id)
        {
            document.getElementById('product_id').value = id;
            document.getElementById('product_form').submit();
        }
    </script>
@endsection


