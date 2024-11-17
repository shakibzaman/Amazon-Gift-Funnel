<x-guest-layout>
    @include('public.layouts.regular-header')
    <div class="progress bg-gray-200 rounded-full overflow-hidden">
        <div class="progress-bar progress-bar-striped bg-blue-500 h-10 flex items-center justify-center text-white text-sm font-semibold"
            role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            60% Complete
        </div>
    </div>
    <div class="mt-4">
        <h3 class="text-2xl font-bold">How was your experience with our Audien Hearing?</h3>
        <p class="text-lg">
            Please answer the following questions, your feedback is very
            valuable to us!
        </p>
    </div>
    <div class="flex flex-col items-center justify-center">
        <div class="w-full p-8 flex flex-col md:flex-row items-center justify-between">
            <!-- First Column (Image) -->
            <div class="md:w-1/3 mb-8 md:mb-0">
                <img src="/image/audienhearingproduct.png" alt="Audien Hearing Product" />
            </div>
            <!-- Second Column (Form) -->
            <div class="md:w-2/3 flex items-center justify-center md:mx-10">
                <div class="relative p-8 rounded-lg shadow-lg w-full">
                    <form id="survey-form" action="{{url('survey-action')}}" method="POST">
                        @csrf
                        <div>
                            <h2 class="text-xl mb-2">Are you satisfied with our Audien Hearing?</h2>
                            <div class="flex justify-center space-x-4 mb-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="satisfaction" value="I hate it" class="hidden peer">
                                    <span
                                        class="bg-red-500 text-white px-4 py-2 rounded peer-checked:border-x-4 peer-checked:border-indigo-600 peer-checked:bg-red-600">I
                                        hate it</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="satisfaction" value="I don't like it" class="hidden peer">
                                    <span
                                        class="bg-red-400 text-white px-4 py-2 rounded  peer-checked:border-x-4 peer-checked:border-indigo-600 peer-checked:bg-red-800">I
                                        don't like it</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="satisfaction" value="It's ok" class="hidden peer">
                                    <span
                                        class="bg-yellow-400 text-white px-4 py-2 rounded peer-checked:border-x-4 peer-checked:border-indigo-600 peer-checked:bg-yellow-800">It's
                                        ok</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="satisfaction" value="I like it" class="hidden peer">
                                    <span
                                        class="bg-blue-400 text-white px-4 py-2 rounded peer-checked:border-x-4 peer-checked:border-red-600 peer-checked:bg-blue-800">I
                                        like it</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="satisfaction" value="I love it" class="hidden peer">
                                    <span
                                        class="bg-green-400 text-white px-4 py-2 rounded peer-checked:border-x-4 peer-checked:border-red-600 peer-checked:bg-green-800">I
                                        love it</span>
                                </label>
                            </div>

                            <p class="text-lg mb-2">Please describe how our Audien Hearing is working for you.</p>
                            <textarea class="w-full p-4 border rounded mb-4" name="review" rows="4"
                                placeholder="Please be specific and honest. How are you using Audien Hearing and how is it helping you?"></textarea>
                            <p class="text-lg mb-2">How likely are you to recommend our Audien Hearing to a friend?</p>
                            <div class="flex justify-center space-x-4 mb-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="recommendation" value="1" class="hidden peer">
                                    <span class="peer-checked:bg-green-600 bg-gray-300 px-4 py-2 rounded">1</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="recommendation" value="2" class="hidden peer">
                                    <span class="peer-checked:bg-green-600 bg-gray-300 px-4 py-2 rounded">2</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="recommendation" value="3" class="hidden peer">
                                    <span class="peer-checked:bg-green-600 bg-gray-300 px-4 py-2 rounded">3</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="recommendation" value="4" class="hidden peer">
                                    <span class="peer-checked:bg-green-600 bg-gray-300 px-4 py-2 rounded">4</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="recommendation" value="5" class="hidden peer">
                                    <span class="peer-checked:bg-green-600 bg-gray-300 px-4 py-2 rounded">5</span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="audin-primary-bg text-white px-6 py-2 rounded">SUBMIT MY
                                    EXPERIENCE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
            <script>
                $(document).ready(function() {
            $("#survey-form").validate({
                rules: {
                    review: {
                        required: true,
                        minlength: 50
                    },
                    recommendation: {
                        required: {
                            depends: function() {
                                return $('input[name="recommendation"]:checked').length === 0;
                            }
                        }
                    }
                },
                messages: {
                    review: {
                        required: "Please provide your feedback.",
                        minlength: "A minimum of 50 characters is required, but please be as detailed as possible."
                    },
                    recommendation: {
                        required: "Please give your recommendation."
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
            </script>
</x-guest-layout>