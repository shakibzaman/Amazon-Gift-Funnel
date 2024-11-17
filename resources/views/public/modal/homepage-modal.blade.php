<div id="myModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-hidden hidden">
    <!-- Modal content -->
    <div class="relative bg-gray-900 bg-opacity-90 p-5 border border-gray-600 w-full h-full overflow-hidden box-border">
        <div class="flex justify-center">
            <img src="image/logo-white.png" class="w-1/2 md:w-1/3 lg:w-1/12" alt="modal-image">
        </div>
        <div class="w-full text-center border-0 mt-10">
            <h1 class="text-4xl lg:text-8xl md:text-4xl font-black text-white">Which of our partners<br/> did you order from?</h1>
        </div>
        <div class="text-center mt-10">
            <div class="grid gap-4">
                <a class="bg-yellow-500 text-black font-bold py-2 px-4 rounded mb-2 w-1/3 mx-auto" id="buy-amazon">Amazon</a>
                <a class="bg-yellow-500 text-black font-bold py-2 px-4 rounded mb-2 w-1/3 mx-auto buy-from-others">Walmart</a>
                <a class="bg-yellow-500 text-black font-bold py-2 px-4 rounded mb-2 w-1/3 mx-auto buy-from-others">TV</a>
                <a class="bg-yellow-500 text-black font-bold py-2 px-4 rounded mb-2 w-1/3 mx-auto buy-from-others">Pharmacies</a>
                <a class="bg-yellow-500 text-black font-bold py-2 px-4 rounded mb-2 w-1/3 mx-auto buy-from-others">Other</a>
            </div>
        </div>
        <div class="flex justify-center -mt-10">
            <img src="image/hearing-kit.png" class="w-full" alt="modal-image">
        </div>
    </div>
</div>



<script>
    // Function to display the modal
    function showModal() {
        $('#myModal').removeClass('hidden').addClass('flex');
    }

    // Function to hide the modal
    function closeModal() {
        $('#myModal').removeClass('flex').addClass('hidden');
    }

    // Add event listeners to buttons
    $('#buy-amazon').on('click', function() {
        closeModal();
    });

    $('.buy-from-others').on('click', function() {
        var buttonText = $(this).text().toLowerCase();
        var url = '/homepage/redirection/' + encodeURIComponent(buttonText);
        window.location.href = url;
    });

    showModal();
</script>