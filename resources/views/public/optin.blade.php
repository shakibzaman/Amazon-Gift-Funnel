<x-guest-layout>
    @include('public.layouts.index-header')
    <!-- Main Content Section -->
    <div class="flex flex-col min-h-screen items-center justify-center">
        <div class="w-full max-w-6xl p-8 flex flex-col md:flex-row items-center justify-between">
            <div class="text-white md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl font-bold mb-4">Get A FREE 1 Year Protection Plan</h1>
                <p class="text-xl font-semibold mb-2">*Conditions Apply:</p>
                <p class="text-lg mb-4">Limited to 1 Year of the protection plan per account per household. The offer is
                    only available for customers that purchased Audien Hearing at full price through our website or
                    through our official seller at Amazon.com. This offer is not dependent on leaving a review on any
                    place nor the quality or manner of feedback that you provide. Activate your free Protection Plan.
                </p>
            </div>
            <div class="bg-gray-100 flex items-center justify-center md:mx-10">
                <div class="form-container relative bg-white p-8 rounded-lg shadow-lg w-full">
                    @if (session('message'))
                    <div class="bg-green-500 text-white px-4 py-4 mt-4 mb-4">
                        {{ session('message') }}
                    </div>
                    @endif
                    <div class="logo-container absolute -top-20 left-4 p-2">
                        <img src="/image/protection-plan.png" alt="Protection Plan 1 Year" class="logo w-1/2 md:w-1/3">
                    </div>
                    <div class="mt-5">
                        <form action="{{ url('optin/store-user-action') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="text" placeholder="Your Name" name="user_name" required>
                            </div>
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="email" placeholder="Your Email Address" name="user_email" required>
                            </div>
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 phone border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="text" placeholder="Your Phone" name="user_phone" required>
                            </div>
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="text" placeholder="Your Address" name="user_address" required>
                            </div>
                            <div class="mb-6">
                                <div class="text-sm font-semibold text-gray-700 mb-2">* Enter a date when you purchased
                                    product</div>
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="date" name="product_date_of_purchased" required>
                            </div>
                            @if($options == null)
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="text" placeholder="Name or retailer Purchased From"
                                    name="product_purchased_from" required>
                            </div>
                            @else
                            <div class="mb-6">
                                <div class="text-sm font-semibold text-gray-700 mb-2">* Select Name or retailer
                                    Purchased From</div>
                                <select name="product_purchased_from"
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    required>
                                    @foreach($options as $option)
                                    <option>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="mb-6">
                                <input
                                    class="w-full py-2 px-4 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                                    type="text" placeholder="Purchased Product Name" name="purchased_product" required>
                                <span class="block text-sm font-semibold text-gray-700 mt-2">* Our team may contact you
                                    to finalize your warranty registration</span>
                            </div>
                            <button type="submit"
                                class="w-full py-3 text-white bg-blue-700 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-800">
                                GET MY FREE 1 Year PLAN!
                            </button>
                        </form>
                    </div>

                    <p class="text-white mt-5"></p>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Footer Section -->
    @include('public.layouts.index-footer')
</x-guest-layout>