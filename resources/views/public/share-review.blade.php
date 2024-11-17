<x-guest-layout>
    @include('public.layouts.regular-header')
    <div class="progress bg-gray-200 rounded-full overflow-hidden">
        <div id="progressBar"
            class="progress-bar progress-bar-striped bg-blue-500 h-6 flex items-center justify-center text-white text-sm font-semibold"
            role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            80% Complete
        </div>
    </div>
    <div class="mt-4">
        <h3 class="text-xl font-bold text-center">CLAIM YOUR BONUS GIFT</h3>
    </div>
    <div class="flex flex-col items-center justify-center">
        <div class="w-full p-8 flex flex-col md:flex-row items-center justify-between">
            <!-- First Column (Image) -->
            <div class="md:w-2/3 mb-8 md:mb-0">
                <div class="col-12 col-md-8">
                    <p class="mb-1">Dear <b>{{$customer->name}}</b>,</p>
                    <p class="mb-3">You're almost complete! Your 1 year protection plan is secured and we'd to like
                        offer you a 2nd free gift.</p>
                    <p class="mb-3">In addition to the free Protection Plan <b> ($50 Value) </b> we would like to send
                        you a finger pulse oximeter or an infrared thermometer <b> ($35 value)</b>, FREE of charge,
                        simply schedule a time with one of our customer success experts for a brief call so that they
                        can ask a couple more follow up questions as well as help ensure you make the most of your
                        product.</p>
                    <p class="mb-0">After this session, they will confirm your address, activate your free Protection,
                        and ship you your free Pulse Oximeter or Thermometer.</p>
                </div>
            </div>
            <!-- Second Column (Form) -->
            <div class="md:w-1/3 flex items-center justify-center md:mx-10">
                <div class="relative p-8 rounded-lg shadow-lg w-full">
                    <img src="/image/leave-us-a-review.png" alt="Audien Hearing Product" />
                </div>
            </div>
        </div>
    </div>

    <div id="popupAlert"
        style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background-color:#4e76be; color:#ffffff; padding:10px; border:1px solid #f5c6cb; border-radius:5px;width: 50%;text-align: center;font-weight: bold;">
        Congratulations !!! <br /> Scheduling Confirmed!
    </div>
    <div id="schedule_meeting">
        <!-- Calendly inline widget -->
        <div class="calendly-inline-widget"
            data-url="https://calendly.com/d/ckks-5qd-jb9/audien-hearing-product-feedback-gift"
            style="min-width:320px;height:630px;"></div>
    </div>
    </div>
    </div>

</x-guest-layout>

<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
<script type="text/javascript">
    // Function to show the popup alert
    function showPopupAlert() {
        var popup = document.getElementById('popupAlert');
        popup.style.display = 'block';
        setTimeout(function() {
            popup.style.display = 'none';
        }, 3000); // Hide after 3 seconds
    }

    // Function to update the progress bar
    function updateProgressBar() {
        var progressBar = document.getElementById('progressBar');
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', '100');
        progressBar.textContent = '100% Complete';
    }

    // Function to set confirmation in local storage
    function setConfirmed() {
        localStorage.setItem('schedulingConfirmed', 'true');
    }

    // Function to check confirmation from local storage
    function checkConfirmed() {
        return localStorage.getItem('schedulingConfirmed') === 'true';
    }

    // Calendly callback function when an event is scheduled
    window.addEventListener('message', function(e) {
        if (e.origin === 'https://calendly.com' && e.data.event && e.data.event === 'calendly.event_scheduled') {
            showPopupAlert();
            updateProgressBar();
            setConfirmed();
        }
    });

    // Check confirmation status on page load
    window.onload = function() {
        if (checkConfirmed()) {
            updateProgressBar();
        }
    }
</script>