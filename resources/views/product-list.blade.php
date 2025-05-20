<!DOCTYPE html>
<html lang="en" class="dark">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>

    <body class="bg-white text-gray-800 dark:bg-[#13122c] dark:text-white">
        <div class="flex justify-between items-center px-6 py-4 shadow-md dark:shadow-none">
            <div class="text-xl font-bold">List Produk</div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('auth.logout') }}" class="text-sm px-3 py-1 bg-red-500 text-white rounded">Logout</a>
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Product List</h2>
                <button onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded">+ Add Product</button>
            </div>
            <div class="overflow-auto rounded-lg shadow">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Product</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Image</th>
                            <th class="px-4 py-2 ml-10">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product_list" class="divide-y divide-gray-200 dark:divide-gray-600">
                        <!-- Produk akan dimuat di sini melalui AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="productModal"
            class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-[#1e1e2f] p-6 rounded w-96">
                <h3 class="text-lg font-semibold mb-4">Add Product</h3>
                <form action="" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf

                    <!-- Nama Produk -->
                    <div class="mb-4">
                        <label for="product_name" class="block text-gray-700">Product Name</label>
                        <input type="text" placeholder="Product" name="nama_produk" id="product_name"
                            class="w-full mb-2 px-3 py-2 border rounded dark:bg-gray-800">
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700">Category ID</label>
                        <input type="text" placeholder="Category" name="category" id="category_id"
                            class="w-full mb-2 px-3 py-2 border rounded dark:bg-gray-800">
                    </div>

                    <!-- Stok -->
                    <div class="mb-4">
                        <label for="stock" class="block text-gray-700">Stock</label>
                        <input type="number" placeholder="Stock" name="stok" id="stock"
                            class="w-full mb-2 px-3 py-2 border rounded dark:bg-gray-800">
                    </div>

                    <!-- Harga -->
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700">Price</label>
                        <input type="text" placeholder="Price" name="harga" id="price"
                            class="w-full mb-2 px-3 py-2 border rounded dark:bg-gray-800">
                    </div>

                    <!-- Gambar -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full mb-2 px-3 py-2 border rounded dark:bg-gray-800">
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-400 rounded">Cancel</button>
                        <button type="submit" id="add" class="px-4 py-2 bg-blue-600 text-white rounded">Add</button>
                    </div>
                </form>


            </div>
        </div>
        <script>
            // const toggleThemeBtn = document.getElementById('toggleTheme');
            // toggleThemeBtn.addEventListener('click', () => {
            //     document.documentElement.classList.toggle('dark');
            // });

            //modal untuk add produk
            function openModal() {

                $('#productForm').attr('action', '/add');

                $('#productModal').removeClass("hidden");
                $("#product_name").val('');
                $("#category_id").val('');
                $("#stock").val('');
                $("#price").val('');
                $('h3').text('add product');
                $('#add').text('add');
                // $('#add').click(function (e) {
                //     e.preventDefault();
                //     $.ajax({
                //         url: "/add",
                //         method: "POST",
                //         data: {
                //             nama_produk: $("#product_name").val(),
                //             category: $("#category_id").val(),
                //             stok: $("#stock").val(),
                //             harga: $("#price").val(),
                //             imaage: $("#image").val(),
                //         },
                //         success: function (response) {
                //             console.log(response);
                //         },
                //         error: function (xhr, status, error) {
                //             console.log(error);
                //         }
                //     });
                // });
            }


            function closeModal() {
                document.getElementById('productModal').classList.add('hidden');
            }

            //fungsi untuk merubah angka ke rupiah
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }


            //fungsi untuk edit produk
            function edit_openModal(item) {

                $('#productForm').attr('action', '/edit/' + item.nama_produk);

                $('h3').text('edit product');
                $('#add').text('edit');
                $("#productModal").removeClass("hidden");
                $("#product_name").val(item.nama_produk);
                $("#category_id").val(item.category);
                $("#stock").val(item.stok);
                $("#price").val(item.harga);


                // $('#add').click(function (e) {
                //     e.preventDefault();
                //     let formData = new FormData();
                //     formData.append('nama_produk', $("#product_name").val());
                //     formData.append('category', $("#category_id").val());
                //     formData.append('stok', $("#stock").val());
                //     formData.append('harga', $("#price").val());
                //     formData.append('image', $('#image')[0].files[0]); // ambil file-nya
                //     $.ajax({
                //         url: "/edit/" + item.nama_produk,
                //         method: "POST",
                //         data: formData,
                //         contentType: false, // harus false
                //         processData: false, // harus false
                //         success: function (response) {
                //             console.log(response);
                //             window.location.reload();
                //         },
                //         error: function (xhr) {
                //             console.error("❌ Gagal mengirim data ke server.");
                //             console.error("Status:", xhr.status);
                //             console.error("Response:", xhr.responseText);
                //         }
                //     });
                // })
            }

            $(document).ready(function () {

                //menyiapkan csrf token untuk post method menggunakan jquery
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });


                //mengambil semua produk dan menaruh di dalam tabel
                function fetchProducts() {
                    $.ajax({
                        url: "/allproduct",
                        method: "GET",
                        dataType: "json",
                        success: function (response) {
                            const { data, categoryName } = response;

                            data.map((item, index) => {
                                console.log(item);
                            })

                            $("#product_list").html(
                                data.map((item, index) => `
                                <tr>
                                    <td class="px-4 py-2">${item.nama_produk}</td>
                                    <td class="px-4 py-2">${item.category.nama_category}</td>
                                    <td class="px-4 py-2">${item.stok}</td>
                                    <td class="px-4 py-2">${formatRupiah(item.harga)}</td>
                                    <td class="px-4 py-2 w-[200px] h-[200px] object-cover rounded-lg"><img src="storage/images/${item.image}" alt="${item.nama_produk}"></td>
                                    <td class="px-4 py-2">
                                        <button onclick="edit_openModal({nama_produk: '${item.nama_produk}', category: '${item.category.id}', stok: '${item.stok}', harga: '${item.harga}'})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                            Edit
                                        </button>
                                        <a href="/delete/${item.id}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"> 
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            `));

                        },
                        error: function (xhr, status, error) {
                            console.error("Gagal mengambil data produk:", error);
                        }
                    });
                }

                // Fetch pertama kali
                fetchProducts();

                // Refresh setiap 3 detik
                setInterval(fetchProducts, 3000);
            });
        </script>
    </body>

</html>