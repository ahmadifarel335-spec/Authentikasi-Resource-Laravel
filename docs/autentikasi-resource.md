# Dokumentasi Autentikasi & Resource Produk

Dokumen ini menjelaskan autentikasi berbasis session dan resource CRUD produk pada aplikasi POS Toko.

## Persiapan Lokal

Aplikasi membutuhkan PHP 8.3 atau lebih baru, Composer, ekstensi PDO MySQL, serta server MySQL/MariaDB yang aktif. Buat database `pos_toko`, lalu sesuaikan koneksi database di `.env` dengan konfigurasi lokal.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class='Database\Seeders\CategorySeeder' --no-interaction
php artisan serve
```

Jika `.env` sudah tersedia, jangan menyalinnya lagi. Jalankan seeder kategori satu kali pada database kosong; slug kategori memiliki batasan unik. `php artisan db:seed` menjalankan seluruh `DatabaseSeeder`, termasuk seeder supplier dan pembuatan 50 produk contoh.

## Alur Autentikasi

Route autentikasi berada di `routes/web.php` dan ditangani oleh `AuthController`.

| Method | URL | Route name | Keterangan |
| --- | --- | --- | --- |
| GET | `/login` | `login` | Menampilkan form masuk |
| POST | `/login` | `login.store` | Memeriksa email dan kata sandi; dibatasi 5 percobaan per menit |
| GET | `/register` | `register` | Menampilkan form pendaftaran |
| POST | `/register` | `register.store` | Membuat akun baru dan langsung masuk |
| POST | `/logout` | `logout` | Keluar dan menginvalidasi session; perlu login |

Pendaftaran meminta nama, email unik, kata sandi minimal 8 karakter, dan konfirmasi kata sandi. Model `User` meng-hash kata sandi melalui cast `hashed`. Setelah login berhasil, session ID diregenerasi; saat logout, session diinvalidasi dan token CSRF diregenerasi.

Route `guest` hanya mengizinkan pengguna yang belum masuk membuka form login dan pendaftaran. Route dashboard dan produk memakai middleware `auth`.

## Dashboard

- `/dashboard` adalah alias terproteksi yang mengarahkan ke dashboard admin.
- `/admin/dashboard` menampilkan jumlah produk, jumlah kategori, produk dengan stok 5 atau kurang, produk yang stoknya habis, dan lima produk terbaru.
- Setelah login atau pendaftaran, pengguna diarahkan ke `/admin/dashboard`.

Ringkasan dashboard disediakan oleh `DashboardController`; tampilan berada di `resources/views/dashboard.blade.php`.

## Resource Produk

Resource didaftarkan menggunakan `Route::resource` di dalam grup middleware `auth`. Aksi `show` tidak didaftarkan.

| Method | URL | Route name | Aksi |
| --- | --- | --- | --- |
| GET | `/admin/produk` | `admin.produk.index` | Daftar produk |
| GET | `/admin/produk/create` | `admin.produk.create` | Form produk baru |
| POST | `/admin/produk` | `admin.produk.store` | Simpan produk |
| GET | `/admin/produk/{product}/edit` | `admin.produk.edit` | Form edit |
| PUT/PATCH | `/admin/produk/{product}` | `admin.produk.update` | Perbarui produk |
| DELETE | `/admin/produk/{product}` | `admin.produk.destroy` | Hapus produk |

Tabel `products` memiliki kolom `category_id`, `name`, `sku`, `price`, dan `stock`. Validasi controller memastikan kategori tersedia, nama dan SKU terisi, SKU unik, serta harga dan stok berupa integer non-negatif. SKU yang sama tetap boleh dipakai saat memperbarui produk itu sendiri. Produk dimuat bersama kategori agar daftar tidak membuat query kategori berulang.

Kategori wajib dipilih ketika menyimpan produk. Daftar kategori awal disediakan oleh `CategorySeeder`; pengelolaan kategori belum termasuk CRUD produk.

## Pengujian

Jalankan seluruh feature test dengan:

```powershell
php artisan test --compact
```

Suite memakai SQLite in-memory sesuai `phpunit.xml`. Jika muncul pesan `could not find driver`, aktifkan ekstensi PHP `pdo_sqlite` dan `sqlite3` untuk CLI.

Test autentikasi ada di `tests/Feature/AuthControllerTest.php`, test dashboard di `tests/Feature/DashboardControllerTest.php`, dan test CRUD produk di `tests/Feature/ProductControllerTest.php`.

## Panduan Screenshot

Gunakan database lokal dan data contoh. Ambil screenshot dengan teks yang terbaca; pisahkan bagian kode yang terlalu panjang daripada mengecilkan zoom. Nama berkas di bawah ini hanya saran agar bukti mudah disusun.

### Screenshot Kode

| Nama berkas | File dan bagian yang ditampilkan | Yang dibuktikan |
| --- | --- | --- |
| `01-route-auth.png` | `routes/web.php`: grup `guest`, route login/register, `throttle:5,1`, serta route logout dengan `auth` | Endpoint autentikasi dan proteksi session |
| `02-auth-login.png` | `AuthController`: method `login` | Validasi kredensial, `Auth::attempt`, regenerasi session, dan redirect |
| `03-auth-register-logout.png` | `AuthController`: method `register` dan `logout` | Validasi pendaftaran, pembuatan user, login otomatis, dan invalidasi session |
| `04-user-password.png` | `app/Models/User.php`: atribut fillable/hidden dan method `casts` | Penyimpanan password menggunakan cast `hashed` |
| `05-route-resource.png` | `routes/web.php`: grup `auth` dan deklarasi `Route::resource('produk', ...)` | Seluruh aksi resource produk hanya bisa diakses setelah login |
| `06-product-controller.png` | `ProductController`: method `index`, `store`, `update`, `destroy`, dan `validatedProductData` | Operasi CRUD, validasi field, serta aturan SKU unik |
| `07-product-model-schema.png` | `app/Models/Product.php` dan migration `create_products_table` | Kolom yang dapat diisi, relasi kategori, dan struktur tabel produk |
| `08-feature-tests.png` | Test autentikasi, dashboard, atau produk; boleh memakai hasil `php artisan test --compact` | Bukti pengujian alur dan validasi |

### Screenshot Tampilan

| Nama berkas | URL / kondisi | Yang perlu terlihat |
| --- | --- | --- |
| `01-login.png` | `/login` dalam keadaan belum login | Form email, kata sandi, ingat saya, dan tautan daftar |
| `02-register.png` | `/register` dalam keadaan belum login | Form nama, email, kata sandi, dan konfirmasi |
| `03-login-error.png` | Kirim kredensial yang salah pada akun demo | Pesan kesalahan login; pastikan tidak ada kata sandi yang terlihat |
| `04-dashboard.png` | `/admin/dashboard` setelah login | Ringkasan produk, kategori, stok, dan produk terbaru |
| `05-product-list.png` | `/admin/produk` setelah login, dengan satu atau lebih produk contoh | Daftar produk beserta aksi Edit dan Hapus |
| `06-product-create.png` | `/admin/produk/create` | Field nama, SKU, kategori, harga, dan stok |
| `07-product-edit.png` | `/admin/produk/{product}/edit` untuk produk contoh | Form edit dengan nilai produk yang sudah terisi |
| `08-product-result.png` | Daftar produk setelah menyimpan atau menghapus produk contoh | Pesan berhasil dan perubahan daftar produk |

Untuk screenshot form resource, buat data uji lokal, misalnya `Teh Melati Demo` dengan SKU `DEMO-001`. Hapus data tersebut sesudah bukti diambil bila tidak diperlukan lagi. Jangan gunakan database produksi.

Jangan sertakan `.env`, password, cookie/session browser, token CSRF, atau data pelanggan asli dalam screenshot. Jika perlu menunjukkan URL, cukup tampilkan path lokal seperti `/admin/produk`.

## Batas Akses dan Catatan

Saat ini tidak ada kolom role, policy, atau pembagian hak akses. Artinya, setiap pengguna yang berhasil mendaftar dan login dapat melihat, mengubah, serta menghapus semua produk. Tambahkan role/policy sebelum aplikasi digunakan oleh beberapa tingkat pengguna.

Route `/test-*` yang tersisa merupakan contoh pembelajaran; khusus `/test-crud` melakukan perubahan data ketika dipanggil. Nonaktifkan atau lindungi route contoh tersebut sebelum aplikasi dipakai di lingkungan produksi.
