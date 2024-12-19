<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex justify-center">
                    <div
                        class="w-full p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <form action="{{ route('payment.method') }}" id="payment-form" method="POST">
                            @csrf
                            <div class="flex flex-wrap mx-4">
                                <div class="w-1/2">
                                    <div class="m-5 w-1/2">
                                        <label for="amount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Amount</label>
                                        <input type="text" name="amount" id="amount"
                                            class="form-input mt-1 block w-full" value="{{ Cart::total() }}" readonly>
                                        <label for="payment-method"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Payment
                                            Method</label>
                                        <select name="payment_method" id="payment-method"
                                            class="form-select mt-1 block w-full">
                                            @foreach ($payment_methods as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="m-5 w-2/3">
                                    <x-button id="pay-button" class="bg-gray-800 hover:bg-gray-500 dark:bg-gray-200">
                                        {{ __('Pay') }}
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="w-full">
                        <div id="credit-card-container" class="m-5 w-1/2">
                            <form id="credit-card-form">
                                <div id="token_errors" class="m-2 text-red-500"></div>
                                <div class="m-2 form-group">
                                    <label for="card-holder-name">Card Holder Name</label>
                                    <input type="text" id="card-holder-name" data-omise="holder_name"
                                        class="form-control" value="test user" placeholder="Card Holder Name">
                                </div>
                                <div class="m-2 form-group">
                                    <label for="card-number">Card Number</label>
                                    <input type="text" id="card-number" data-omise="number" class="form-control"
                                        value="424242424242424" placeholder="Card Number">
                                </div>
                                <div class="m-2 form-group">
                                    <label for="expiry-date">Expiry Date</label>
                                    <input type="text" id="expiry-month" data-omise="expiration_month" size="4"
                                        value="11" class="form-control" placeholder="MM">/
                                    <input type="text" id="expiry-year" data-omise="expiration_year" size="4"
                                        value="27" class="form-control" placeholder="YY">
                                </div>
                                <div class="m-2 form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" data-omise="security_code" size="8"
                                        class="form-control" placeholder="CVV">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.omise.co/omise.js"></script>
        <script>
            var button = document.getElementById('pay-button');
            var form = document.getElementById('payment-form');
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var payment_method = document.getElementById('payment-method').value;
                console.log(payment_method);
                if (payment_method == 'credit_card') {
                    var card  = {
                        name: document.getElementById('card-holder-name').value,
                        number: document.getElementById('card-number').value,
                        expiration_month: document.getElementById('expiry-month').value,
                        expiration_year: document.getElementById('expiry-year').value,
                        security_code: document.getElementById('cvv').value
                    };
                    Omise.setPublicKey('{{ $publicKey }}');
                
                    Omise.createToken('card', card, function(statusCode, response) {
                        console.log(response);
                        if (response.object == "error" || !response.card.security_code_check) {
                            // Display an error message.
                            var message_text = "SET YOUR SECURITY CODE CHECK FAILED MESSAGE";
                            if (response.object == "error") {
                                message_text = response.message;
                            }
                            document.getElementById("token_errors").html(message_text);
                        } else {
                            // Then fill the omise_token.
                            var hiddenInput = document.createElement('input');
                            hiddenInput.setAttribute('type', 'hidden');
                            hiddenInput.setAttribute('name', 'omiseToken');
                            hiddenInput.setAttribute('value', response.id);
                            form.appendChild(hiddenInput);
                            form.submit();
                        }
                    });
                } else {
                    form.submit();
                }
            });
        </script>
    @endpush
</x-app-layout>
