@extends('layouts.app')

@section('title')
    <title>Create Product</title>
@endsection

@section('content')
    <form action="{{ route('products.store') }}" method="POST"
        class="d-flex flex-column justify-content-start"
    >
        @csrf

        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" id="productName" placeholder="Ex: T-shirt">
        </div>

        <div class="row g-3">

            <div class="col-sm-3 mb-3">
                <label for="productPrice" class="form-label">Product Price</label>
                <input type="number" class="form-control" name="price" id="productPrice" placeholder="Ex: 15.25">
            </div>

            <div class="col-sm-5 mb-3">
                <label for="productCurrency" class="form-label">Product Currency</label>
                <select class="form-select" name="currency"
                        id="productCurrency"
                        aria-label="currency selection"
                >
                    @foreach(\App\Models\Product::CURRENCIES_MAP as $key => $currency)
                        <option value="{{ $key }}">{{ $currency }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4 mb-3">
                <label for="paymentType" class="form-label">Payment Type</label>
                <select class="form-select" name="payment_type"
                        id="paymentType"
                >
                    @foreach(\App\Enums\PaymentType::TYPE_MAP as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach

                </select>
            </div>

        </div>

        <div class="mb-3 d-none" id="productInterval">
            <label for="productInterval" class="form-label">Subscription Frequency</label>
            <select class="form-select" name="interval">
                @foreach(\App\Enums\RecurringFrequency::FREQUENCY_MAP as $key => $frequency)
                    <option value="{{ $key }}">{{ $frequency }}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary mb-3">Add product</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        const defaultPaymentType = "{{ \App\Enums\PaymentType::ONE_TIME }}";

        document.getElementById("paymentType").addEventListener("change", function() {
            const selectedOption = this.value;
            const productIntervalSelect = document.getElementById("productInterval");

            if (selectedOption !== defaultPaymentType) {
                productIntervalSelect.classList.remove("d-none");
            } else {
                productIntervalSelect.classList.add("d-none");
            }
        });
    </script>
@endsection


