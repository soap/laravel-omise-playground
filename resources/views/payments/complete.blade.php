<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Complete') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-2xl dark:text-gray-200">
                        Payment Complete {{ $id }}
                    </div>
                    <div class="mt-4 text-gray-500 dark:text-gray-300">
                        Thank you for your payment. Your payment has been successfully processed.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>