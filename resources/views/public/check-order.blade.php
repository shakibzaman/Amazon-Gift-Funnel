<x-guest-layout>
    @include('public.layouts.regular-header')

    <!-- Main Content Section -->
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-6xl p-8 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-8 md:mb-0">

                <img src="https://go.bfrshop.com/hosted/images/38/541fb0d3c711e892aa9bb9324679c8/32.jpg" />
                <h1 class="text-4xl font-bold mb-4">How do I find my order ID?</h1>
                <p class="text-2xl font-bold mb-4">
                    Check in your
                    <a href="https://www.amazon.com/gp/css/order-history/ref=nav_youraccount_orders" target="_blank"
                        class="text-blue-500"> Amazon Account Order History,</a>
                    in your email or in the receipt you received with your product.
                </p>
            </div>
            <div class="bg-gray-100 flex items-center justify-center md:mx-10">
                <div class="form-container relative text-white p-8 rounded-lg shadow-lg w-full audin-primary-bg">
                    <form class="protection-plan-form " action="{{url('check-order')}}" method="POST">
                        @csrf
                        <h1 class="text-xl font-bold mb-8">To help Us Locate Your Order Please Fill The Form Below</h1>
                        <select class="search_type text-black w-full mb-4 p-2 border rounded" name="search_type">
                            <option value="1">Amazon.com</option>
                            {{-- <option value="2">Walmart.com</option> --}}
                        </select>
                        <input type="text" name="order_id" placeholder="Enter Order ID (e.g. 112-7343300-2776683)"
                            class="w-full mb-4 p-2 border text-black rounded">
                        <button type="submit" class="w-full text-white bg-green-600 p-2 rounded">SUBMIT</button>
                    </form>
                    <p style="color:#ffffff; font-size: 15px;">
                        * We don't share your personal info with anyone. Check out our
                        <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                        for more information.
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-guest-layout>