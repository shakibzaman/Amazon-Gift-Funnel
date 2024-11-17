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
                    <div class="logo-container absolute -top-20 left-4 p-2">
                        <img src="/image/protection-plan.png" alt="Protection Plan 1 Year" class="logo w-1/2 md:w-1/3">
                    </div>
                    <form class="protection-plan-form" action="{{url('customer')}}" method="POST">
                        @csrf
                        <h1 class="text-xl font-bold mb-4">Claim Your FREE 1 Year Protection Plan Today.</h1>
                        <p class="mb-4">Please provide the email associated with your Audien Hearing order.</p>
                        <input type="text" name="name" placeholder="Your Name" class="w-full mb-4 p-2 border rounded"
                            required>
                        <input type="email" name="email" placeholder="Your Email Address"
                            class="w-full mb-4 p-2 border rounded" required>
                        <input type="text" name="phone" placeholder="Your Phone"
                            class="w-full mb-4 p-2 border rounded phone" required>
                        <p class="text-sm text-gray-500 mb-4">*Our team may contact you to finalize your warranty
                            registration</p>
                        <button type="submit" class="w-full audin-primary-bg text-white p-2 rounded">GET MY FREE 1 Year
                            PLAN!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('public.modal.homepage-modal')
    <!-- Footer Section -->
    @include('public.layouts.index-footer')


</x-guest-layout>