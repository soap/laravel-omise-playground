<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Pending') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-2xl dark:text-gray-200">
                        Payment Pending {{ $payment_method }}
                        
                    </div>
                    <div class="mt-4 text-gray-500 dark:text-gray-300">
                        <span class="text-sm">Please scan QR code to complete payment.</span>
                    </div>
                    <div class="mt-4 text-gray-500 dark:text-gray-300">
                        <img src="{{ $result['qr_image'] }}" class="object-scale-down h-32 w-32" alt="QR Code" class="w-1/2 mx-auto">
                        <span>Please pay with in : {{ $result['expires_at'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>