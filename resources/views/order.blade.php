<x-layout>
    <!-- mengambil data nomor meja dan mengirim data ke component modal saat pertama kali mengakses /order/nomor meja -->
    <x-modal>{{ $no_meja }}</x-modal>
    <!-- list_produkId_qty berisi produk id dan qty dalam bentuk array yang akan digunakan untuk mengurangi stok -->

    <nav
        class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
                <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Toggle sidebar</span>
                </button>

                <!-- Fitur Search -->
                <!-- <form action="#" method="GET" class="hidden md:block md:pl-2">
                    <label for="topbar-search" class="sr-only">Search</label>
                    <div class="relative md:w-64">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                                </path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="topbar-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search" autocomplete="off" />
                    </div>
                </form> -->

            </div>
        </div>
    </nav>

    <!-- Sidebar -->

    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">

            <!-- Fitur Search Mobile -->
            <!-- <form action="#" method="GET" class="md:hidden mb-2">
                <label for="sidebar-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                            </path>
                        </svg>
                    </div>
                    <input type="text" name="search" id="sidebar-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search" />
                </div>
            </form> -->
            <ul class="space-y-2">
                <li>
                    <a href="/checkout/{{ $no_meja }}"
                        class="flex items-center p-2 ml-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 18 21">
                            <path
                                d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                        </svg>
                        <span class="ml-1">keranjang anda</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <main class="p-4 md:ml-64 mx-auto h-auto pt-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            @foreach ($data as $key => $item)
                <div
                    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <img class="p-8 mx-auto rounded-t-lg object-cover rounded h-[300px]"
                        src="{{ asset('storage/images/' . $item['image']) }}" alt="{{ $item['nama_produk'] }}" />
                    <div class="px-5 pb-5">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ $item["nama_produk"] }}
                        </h5>
                    </div>
                    <div class="flex items-center justify-between p-5">
                        <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $price[$key] }}</span>
                        <button id="button_order" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                            data-nama_produk="{{ $item["nama_produk"] }}" data-id_produk="{{ $item["id"] }}"
                            class="button_order w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            masuk ke keranjang</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sidebar Keranjang di Sebelah Kanan -->
        <!-- <aside
            class="fixed top-0 right-0 z-40 w-64 h-screen pt-14 bg-white border-l border-gray-200 dark:bg-gray-800 dark:border-gray-700 overflow-y-auto"
            aria-label="Keranjang Sidebar">
            <div class="py-5 px-3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Keranjang Anda</h2>
                @if (Cookie::has('keranjang'))
                    @php
                        $keranjang = json_decode(Cookie::get('keranjang'), true);
                    @endphp
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-200">
                        @foreach ($keranjang as $item)
                            <li class="border-b border-gray-300 dark:border-gray-600 pb-2">
                                <p><span class="font-medium">Menu:</span> {{ $item['produk_name'] }}</p>
                                <p><span class="font-medium">Jumlah:</span> {{ $item['quantity'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Keranjang masih kosong.</p>
                @endif
                <a href="/checkout/{{ $no_meja }}"
                    class="mt-4 inline-block w-full text-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Checkout
                </a>
            </div>
        </aside> -->


        

    </main>
</x-layout>