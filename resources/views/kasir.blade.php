<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>kasir</title>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="bg-[#1B1B3A] h-screen flex">
        <!-- left side bar -->
        <aside class="lg:h-screen lg:w-48 bg-[#1f2937] lg:flex hidden justify-center">
            <ul class="text-white text-center flex flex-col mt-20 -ml-[1rem] gap-8">
                <a href="#" class="hover:bg-gray-700 rounded-lg cursor-pointer p-2">
                    <svg class="ml-4 h-10 w-10 fill-current text-gray-800 dark:text-white"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="#000000">
                        <path
                            d="m160-120-80-80h800l-80 80H160Zm-40-120q6-18 16-34t24-30v-296h-40v-60h40v-30h-40v-60h40v-30h-40v-60h280q33 0 56.5 23.5T480-760v10h360v60H480v10q0 33-23.5 56.5T400-600h-80v244q14 2 28 6t26 12q26-65 83-103.5T583-480q90 0 153.5 61.5T800-268v28H120Zm334-80h252q-17-36-50-58t-73-22q-42 0-77 21t-52 59ZM320-750h80v-30h-80v30Zm0 90h80v-30h-80v30Zm-100-90h40v-30h-40v30Zm0 90h40v-30h-40v30Zm0 314q10-5 19.5-7.5T260-358v-242h-40v254Zm360 26Z" />
                    </svg>
                    <p class="font-bold">Dine in</p>
                </a>
                <a href="#" class="hover:bg-gray-700 rounded-lg cursor-pointer p-2">
                    <svg class="ml-5 h-10 w-10 fill-current text-gray-800 dark:text-white"
                        xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#000000">
                        <path
                            d="M312-240h338l19-280H292l20 280Zm-26-360h389l3-50-112-110H394L282-650l4 50Zm-76 68L80-662l56-56 64 64-2-24 162-162h240l162 162-2 24 64-64 56 56-130 130H210Zm28 372-28-372h540l-28 372H238Zm242-440Zm1 80Z" />
                    </svg>
                    <p class="font-bold">Take Away</p>
                </a>
                <a href="#" class="hover:bg-gray-700 rounded-lg cursor-pointer p-2">
                    <svg class="ml-5 h-10 w-10 fill-current text-gray-800 dark:text-white"
                        xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#000000">
                        <path
                            d="M120-80v-800l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v800l-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60Zm120-200h480v-80H240v80Zm0-160h480v-80H240v80Zm0-160h480v-80H240v80Zm-40 404h560v-568H200v568Zm0-568v568-568Z" />
                    </svg>
                    <p class="font-bold">Order List</p>
                </a>

                <a
                    class="w-auto h-auto text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 cursor-pointer">Log
                    Out</a>
            </ul>
        </aside>

        <!-- Main content -->
        <main class="py-8 px-8 flex flex-col gap-10 flex-grow overflow-y-auto">
            <!-- Search bar -->
            <div class="flex">
                <form action="" class="min-w-full">
                    <div class="relative w-full max-w-md">
                        <span class="absolute inset-y-5 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16z" />
                            </svg>
                        </span>
                    </div>
                    <input type="text" placeholder="search"
                        class="bg-[#374151] text-gray-300 text-center border-[#374151] p-2 rounded lg:w-[45rem] w-full focus:placeholder-transparent">
                </form>
            </div>

            <!-- Filter -->
            <form class="flex w-full h-auto text-lg">
                <div class="overflow-x-auto flex gap-3">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="pilihan" value="/allproduct" class="hidden peer" checked>
                        <span
                            class="peer-checked:bg-green-500 peer-checked:text-gray-200 hover:bg-gray-600 bg-[#374151] rounded-full px-4 py-2 transition-all duration-300 ease-in-out text-gray-200">All</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="pilihan" value="/" class="hidden peer">
                        <span
                            class="peer-checked:bg-green-500 peer-checked:text-gray-200 hover:bg-gray-600 bg-[#374151] rounded-full px-4 py-2 transition-all duration-300 ease-in-out text-gray-200">Mie</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="pilihan" value="endpoint" class="hidden peer">
                        <span
                            class="peer-checked:bg-green-500 peer-checked:text-gray-200 hover:bg-gray-600 bg-[#374151] rounded-full px-4 py-2 transition-all duration-300 ease-in-out text-gray-200">Nasi</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="pilihan" value="endpoint" class="hidden peer">
                        <span
                            class="peer-checked:bg-green-500 peer-checked:text-gray-200 hover:bg-gray-600 bg-[#374151] rounded-full px-4 py-2 transition-all duration-300 ease-in-out text-gray-200">Teh</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="pilihan" value="endpoint" class="hidden peer">
                        <span
                            class="peer-checked:bg-green-500 peer-checked:text-gray-200 hover:bg-gray-600 bg-[#374151] rounded-full px-4 py-2 transition-all duration-300 ease-in-out text-gray-200">Kopi</span>
                    </label>
                </div>
            </form>

            <!-- card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-4" id="card_container">
                <!-- Card 1 -->

            </div>

        </main>

        <form action=""
            class="lg:h-[87.5vh] w-64 h-screen bg-[#1f2937] mt-auto ml-auto mr-0 py-4 px-4 md:static absolute hidden md:flex flex-col">
            <input type="text" placeholder="input customer name" required
                class="bg-[#374151] text-gray-400 text-center border-[#374151] p-2 rounded w-full focus:placeholder-transparent">

            <aside>

            </aside>
        </form>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

            window.onload = function () {
                fetchdata('/allproduct'); // hanya sekali di-load
            };


            function addToCart(id) {
                console.log(id)
            }

            function fetchdata(endpoint) {
                $.ajax({
                    url: `${endpoint}`,
                    method: "GET",
                    dataType: "json",
                    success: function (response) {
                        const { data } = response
                        $('#card_container').empty();
                        data.map(function (item) {
                            $('#card_container').append(`
                            <div class="bg-[#1f2937] rounded-lg shadow-md overflow-hidden text-white">
                                <img src="https://via.placeholder.com/300x200"
                                    class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h2 class="text-lg font-bold mb-2">${item.nama_produk}</h2>
                                    <p class="text-xl font-semibold mb-4">Rp ${item.harga},00</p>
                                    <button
                                        onclick="addToCart(${item.id})" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded transition-all duration-200">
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        `)
                        })
                    }

                })
            }

            $(document).ready(function () {


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('input[name="pilihan"]').on('change', function () {
                    nilaiDipilih = $(this).val();
                    setInterval(() => fetchdata(`/allproduct`), 3000);
                });



            })
        </script>
    </body>

</html>