<x-guest-layout>
	@include('public.layouts.regular-header')
	<div class="progress bg-gray-200 rounded-full overflow-hidden">
		<div id="progressBar"
			class="progress-bar progress-bar-striped bg-blue-500 h-6 flex items-center justify-center text-white text-sm font-semibold"
			role="progressbar" style="width: 90%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
			90% Complete
		</div>
	</div>
	<div class="mt-4">
		<h1 class="text-xl font-bold text-center">UPDATE YOUR ADDRESS</h1>
	</div>
	<div class="flex flex-col items-center justify-center">
		<div class="w-full p-8 flex flex-col md:flex-row items-center justify-between">
			<div class="md:w-2/3 mb-8 md:mb-0 mx-auto">
				<form action="{{ url('update-address') }}" method="POST">
					@csrf
					<div class="grid gap-4 mb-4">
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="Full Name"
								name="full_name" value="{{ $customer->name }}" required />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded"
								placeholder="Full Address" name="full_address" value="{{ $customer->address }}"
								required />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="City"
								name="city" value="{{ $customer->city }}" required />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="State"
								name="state" value="{{ $customer->state }}" required />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded"
								placeholder="Phone Number" name="phone" value="{{ $customer->phone }}" />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="ZIP Code"
								name="zip" value="{{ $customer->zip }}" />
						</div>
						<div class="col-span-12">
							<input type="text" class="w-full p-2 border border-gray-300 rounded" placeholder="Country"
								name="country" value="{{ $customer->country }}" />
						</div>
						<div class="mx-auto w-100">
							<input type="submit" class="bg-blue-500 text-white p-2 rounded cursor-pointer"
								value="This is my shipping address" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	</div>
	</div>

</x-guest-layout>