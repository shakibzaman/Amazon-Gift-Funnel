<x-guest-layout>
    @include('public.layouts.regular-header')
    <div class="progress bg-gray-200 rounded-full overflow-hidden mb-10 mt-10">
        <div id="progressBar"
            class="progress-bar progress-bar-striped bg-blue-500 h-6 flex items-center justify-center text-white text-sm font-semibold"
            role="progressbar" style="width: 100%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            100% Complete
        </div>
    </div>
    <div class="mt-4 mb-4">
        <h1 class="text-2xl font-bold text-center">Thank You! Your Survey is Complete.</h1>
        <h3 class="text-center text-lg"> We will Activate your free 1 Year Protection Plan shortly.</h3>
    </div>
    </div>
    </div>

</x-guest-layout>