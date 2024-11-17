<x-guest-layout>
	@include('public.layouts.regular-header')
	<div class="flex flex-col items-center justify-center mt-5">
		<div class="w-full p-8 flex flex-col md:flex-row items-center justify-between">
			<!-- First Column (Image) -->
			<div class="md:w-1/2 mb-8 md:mb-0">
				<div class="col-12 col-md-8">
					<h2 class="text-4xl font-extrabold mb-2">You don't qualify yet.
						But you will soon!</h2>
					<h4 class="text-indigo-700 text-2xl font-extrabold mb-2">
						Please note that to qualify you need to use the product for more than 7 days.
					</h4>
					<p class=" mb-2">The conditions to qualify for our promotion are:</p>
					<ol class="text-l list-decimal font-bold">
						<li class="text-red-500 mb-2">
							<i class="fa fa-calendar fa-fw"></i>
							<span>Have been actively using Audien Hearing for 7 days or more.</span>
						</li>
						<li class="mb-2">
							<span>You agree to send us your experience with Audien Hearing.</span>
						</li>
						<li class="mb-2">
							<span>Only valid for customers that bought the product at full price
								through our website or through Amazon.com</span>
						</li>
					</ol>

					<h4 class="text-indigo-700 text-2xl font-extrabold mb-4">
						Please come back in a few days and we will be able to process your
						request.
					</h4>
				</div>
			</div>
			<!-- Second Column (Form) -->
			<div class="md:w-1/2 flex items-center justify-center md:mx-10">
				<div class="relative p-8 rounded-lg">
					<img src="/image/audienhearingproduct.png" alt="Audien Hearing Product" />
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>

</x-guest-layout>