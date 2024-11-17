<x-guest-layout>
    @include('public.layouts.regular-header')
    <div class="flex flex-col items-center justify-center mt-5">
        <div class="w-full p-8 flex flex-col md:flex-row items-center justify-between">
            <!-- First Column (Image) -->
            <div class="md:w-1/2 mb-8 md:mb-0">
                <div class="col-12 col-md-8">
                    <h4 class="text-red-600 text-2xl font-extrabold mb-2">Free Gift already requested.</h4>
                    <h3 class=" text-4xl font-extrabold mb-2">
                        Our records indicate that you already claimed your free 1 Year Protection Plan before.
                    </h3>
                    <p class="mb-2">The conditions to qualify for our promotion are:</p>
                    <ul class="text-lg">
                        <li class="text-red-500 mb-2">
                            <i class="fa fa-gift fa-fw"></i>
                            <span class="px-2">Limited to free 1 Year Protection Plan per Audien hearing product.</span>
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-commenting fa-fw"></i>
                            <span class="px-2">​You Agree to send us <b>your experience</b> with Audien Hearing.</span>
                        </li>
                        <li class="mb-2">
                            <i class="fa-brands fa-amazon"></i>
                            <span class="px-2">Only valid for customers that bought the product at full price
                                through our website or through Amazon.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Second Column (Form) -->
            <div class="md:w-1/2 flex items-center justify-center md:mx-10">
                <div class="relative p-8 rounded-lg">
                    <img src="/image/product.png" alt="Audien Hearing Product" />
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

</x-guest-layout>