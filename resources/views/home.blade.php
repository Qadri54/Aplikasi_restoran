<x-layout>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Masukkan Nomor Meja
                </h1>
                <form class="space-y-4 md:space-y-6" action="{{ route('set_meja') }}" method="post">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Meja</label>
                        <input type="text" autocomplete="off" name="no_meja" id="email"
                            class="bg-gray-50 border focus:placeholder-transparent border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="nomor meja tampat kamu duduk" required="">
                        @error('no_meja')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">masuk</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>