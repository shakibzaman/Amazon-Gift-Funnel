<x-guest-layout>
    @include('public.layouts.regular-header')
    <div class="progress bg-gray-200 rounded-full overflow-hidden">
        <div id="progressBar"
            class="progress-bar progress-bar-striped bg-blue-500 h-6 flex items-center justify-center text-white text-sm font-semibold"
            role="progressbar" style="width: 90%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            90% Complete
        </div>
    </div>
    @if (session('error'))
    <div class="bg-red-500 text-white text-center mt-5 px-4 py-4">
        {{ session('error') }}
    </div>
    @endif
    <div class="mt-4 mb-4">
        <h1 class="text-xl font-bold text-center">CONFIRM YOUR ADDRESS</h1>
        <h3 class="text-center"> Please confirm if this is the address where you'd like us to ship
            your second free gift</h3>
        <div class=" border  px-4 py-4 text-white">
            <h2 class="text-center">Your Current adress is </h2>
            <div class="p-4 bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y mx-auto">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Field</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Name</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Address</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->address }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Phone</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->phone }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Email</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">City</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->city }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">State</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->state }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ZIP Code</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->zip }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Country</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->country }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex w-100 flex-column mt-4">
        <div class="w-1/2">
            <a href="{{ route("order.store_address") }}"
                class="bg-red-400 px-6 py-4 uppercase text-white font-extrabold">no, update the address</a>
        </div>
        <div class="w-1/2">
            <a href="{{ route("order.ship_product") }}"
                class="bg-green-500 px-6 py-4 uppercase text-white font-extrabold">yes, the address is correct</a>
        </div>

    </div>

    </div>
    </div>

</x-guest-layout>