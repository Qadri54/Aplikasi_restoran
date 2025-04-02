<x-layout>
    <!-- Navbar -->
     <?php $total_bayar = 0 ?>
    <nav>
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
            </div>
        </div>
    </nav>

    <!-- Side bar -->
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2 -mt-5">
                <li>
                    <a href="/meja/{{ $no_meja }}"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <img class="h-[25px] w-[25px]" src="{{ asset('img/home.png') }}" alt="home">
                        <span class="ml-3">back to home</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>


    <!-- Main -->
    <main class="p-4 md:ml-64 h-auto lg:pt-10 pt-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 ml-10 mb-4">
            @foreach ($orders as $order)
                <div
                    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                    <div class="px-5 pb-5">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-800 dark:text-white mt-3">No Meja :
                            {{ $order["nomor_meja"] }}
                        </h5>
                        <h5 class="text-xl font-semibold tracking-tight text-gray-800 dark:text-white mt-3">Nama pesanan :
                            {{ $order["nama_pesanan"] }}
                        </h5>
                        <h5 class="text-xl font-semibold tracking-tight text-gray-800 dark:text-white mt-3">jumlah pesanan :
                            {{ $order["jumlah"] }}
                        </h5>
                        <h5 class="text-xl font-semibold tracking-tight text-gray-800 dark:text-white mt-3">harga_satuan :
                            {{ $order["harga"] }}
                            @php
                             $harga = (int)$order["harga"];
                             $total_bayar += $harga;
                            @endphp
                        </h5>
                        <div class="flex items-center mt-2.5 mb-5">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-l font-bold text-gray-800 dark:text-white">total harga:
                                {{ $order["total_harga"]    }}</span>
                            <p class="dark:text-white text-slate-800 text-center">status :
                                <span class="text-yellow-600">{{ $order["status"] }}</span>
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-5 -ml-1">
                            <form action="{{ route('delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $order['id'] }}">
                                <input type="hidden" name="status" value="{{ $order['status'] }}">
                                <!-- mengecek status order jika tidak pending maka button menjadi disabled -->
                                @if ($order['status'] != 'pending')
                                    <button type="submit" id="button_order" data-modal-target="crud-modal"
                                        data-modal-toggle="crud-modal" disabled
                                        class="button_order w-auto text-white bg-blue-500 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-500 focus:outline-none dark:focus:ring-blue-800 font-semibold">cancel
                                        order</button>
                                @else
                                    <button type="submit" id="button_order" data-modal-target="crud-modal"
                                        data-modal-toggle="crud-modal"
                                        class="button_order w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 font-semibold">cancel
                                        order</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
        <form action="{{ route('test') }}" method="post" class="w-full flex justify-center">
            @csrf
            <input type="hidden" value="{{  $transaction_id }}" name="id">
            <input type="hidden" value="{{ $total_amount }}" name="amount">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 18 21">
                    <path
                        d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                </svg>
                chekout sekarang
            </button>
        </form>
    </main>
</x-layout>