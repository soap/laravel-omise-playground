<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form id="checkoutForm" method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <input type="hidden" name="omiseToken" id="omiseToken" />
                    <input type="hidden" name="omiseSource" id="omiseSource" />
                    <input type="hidden" name="currency" id="currency" value="thb" />
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                                    <input type="text" name="name" id="name" autocomplete="name" class="mt-1 focus">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Amount</label>
                                    <input type="text" name="amount" id="amount" autocomplete="amount" class="mt-1 focus">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6">
                            <button type="submit" id="checkoutButton" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Checkout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.omise.co/omise.js"></script>
    <script>
        OmiseCard.configure({
            publicKey: '{{ $publicKey }}',
            currency: 'thb',
        });
        var button = document.getElementById('checkoutButton');
        var form = document.getElementById('checkoutForm');
        button.addEventListener('click', function(event) {
            event.preventDefault();
            OmiseCard.open({
                amount: document.getElementById('amount').value * 100,
                currency: document.getElementById('currency').value,
                defaultPaymentMethod: 'credit_card',
                submitFormTarget: '#checkoutForm',
                frameDescription: "Join Joy Tour",
                onCreateTokenSuccess: function(token) {
                    if (token.startsWith("tokn_")) {
                        form.omiseToken.value = token;
                    } else {
                        form.omiseSource.value = token;
                    };
                    form.submit();
                },
                onFormClosed: function() {
                    console.log('Form was closed');
                },
            });
        });
    </script>
    @endpush
</x-app-layout>