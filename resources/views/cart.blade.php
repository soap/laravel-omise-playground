<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart Items') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container px-1 mx-auto">
                    <div class="flex justify-center my-6">
                        <div
                            class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                            @if ($message = Session::get('success'))
                                <div class="p-4 mb-3 bg-green-400 rounded">
                                    <p class="text-green-800">{{ $message }}</p>
                                </div>
                            @endif
                            <div class="flex-1">
                                <table class="table table-auto w-full text-sm lg:text-base" cellspacing="0">
                                    <thead>
                                        <tr class="h-12 uppercase">
                                            <th class="hidden md:table-cell"></th>
                                            <th class="text-left">Name</th>
                                            <th class="pl-5 text-left lg:text-center lg:pl-0">
                                                <span class="lg:hidden" title="Quantity">Qtd</span>
                                                <span class="hidden lg:inline">Quantity</span>
                                            </th>
                                            <th class="hidden text-right md:table-cell"> price</th>
                                            <th class="hidden text-right md:table-cell"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td class="hidden pb-4 md:table-cell">
                                                    <a href="#">
                                                        <img src="{{ $item->options->image }}" class="w-20 rounded"
                                                            alt="Thumbnail">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="#">
                                                        <p class="mb-2 md:ml-4">{{ $item->name }}</p>
                                                    </a>
                                                </td>
                                                <td class="justify-center mt-6 md:justify-end md:flex">
                                                    <div class="h-10 w-30">
                                                        <div class="relative flex flex-row w-full h-8">
                                                            <form action="{{ route('cart.update') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="rowId"
                                                                    value="{{ $item->rowId }}">
                                                                <input type="number" name="qty"
                                                                    value="{{ $item->qty }}"
                                                                    class="w-1/3 text-center" />
                                                                <button type="submit"
                                                                    class="px-2 pb-2 ml-2 text-white bg-blue-500">update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="hidden text-right md:table-cell">
                                                    <span class="text-sm font-medium lg:text-base">
                                                        {{ Number::currency($item->price, 'THB') }}
                                                    </span>
                                                </td>
                                                <td class="hidden text-right md:table-cell">
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->rowId }}"
                                                            name="rowId">
                                                        <button class="px-4 py-2 text-white bg-red-600">x</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div>
                                    <span class="mr-20">Tax: {{ Cart::tax() }}</span><span>Total: ${{ Cart::total() }}</span>
                                </div>
                                <div>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button class="px-6 py-2 text-red-800 bg-red-300">Remove All Cart</button>
                                    </form>
                                    <a href="{{ route('checkout') }}"
                                        class="px-6 py-2 text-white bg-blue-800">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
