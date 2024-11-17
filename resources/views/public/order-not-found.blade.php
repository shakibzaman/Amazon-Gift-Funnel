<x-guest-layout>
    @include('public.layouts.regular-header')

    <!-- Main Content Section -->
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-6xl p-8 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl font-bold mb-4">We couldn't find your order in our database...</h1>
                <p class="text-2xl font-bold mb-4 text-blue-500">
                    Please try again or email us at support@audienhearing.com with your order ID.
                </p>
            </div>
            <div class="bg-gray-100 flex items-center justify-center md:mx-10">
                <div class="form-container relative text-white p-8 rounded-lg shadow-lg w-full audin-primary-bg">
                    <form class="protection-plan-form " action="{{url('check-order')}}" method="POST">
                        @csrf
                        <h1 class="text-xl font-bold mb-8">PLEASE ENTER YOUR ORDER ID BELOW</h1>
                        <select class="search_type text-black w-full mb-4 p-2 border rounded" name="search_type">
                            <option value="1">Amazon.com</option>
                            {{-- <option value="2">Walmart.com</option> --}}
                        </select>
                        <input type="text" name="order_id" placeholder="Enter Order ID (e.g. 112-7343300-2776683)"
                            class="w-full mb-4 p-2 border text-black rounded">
                        <button type="submit" class="w-full text-white bg-green-600 p-2 rounded">TRY AGAIN WITH THIS
                            ORDER ID</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

</x-guest-layout>
<script>
    $(document).ready(function() {
        $('.phone').mask('(000) 000-0000');
    })
</script>