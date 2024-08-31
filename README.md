# Test laravel Fullstack Programmer DDMS

Pastikan kamu sudah menginstall:
- PHP 8.2.23
- Composer
- MySQL

## Langkah-langkah Penggunaan

Setelah repository diclone atau didownload, ikuti langkah-langkah berikut untuk menjalankan aplikasi:

1. **Clone Repository**
   
   Clone repository ini ke dalam direktori lokal:

   ```bash
   git clone https://github.com/HenochYanuar/Pencatatan-Pembelian-Konsumen.git
   ```

   Masuk ke dalam direktori project:

   ```bash
   cd Pencatatan-Pembelian-Konsumen
   ```

2. **Install Dependencies**

   Jalankan perintah berikut untuk menginstall semua dependencies yang diperlukan:

   ```bash
   composer install
   ```

3. **Buat Database**

   Buat sebuah database baru di MySQL dengan nama order_product_ddms. Kamu bisa menggunakan command line atau tools seperti phpMyAdmin.

   ```sql
   CREATE DATABASE order_product_ddms;
   ```

4. **Konfigurasi .env**

   Salin file .env.example menjadi .env dan atur konfigurasi database kamu di dalam file .env:

   ```bash
   cp .env.example .env
   ```

   Lalu, sesuaikan konfigurasi database di .env:

   ```dotenv
   DB_DATABASE=order_product_ddms
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```

5. **Migrasi Database**

   Jalankan perintah berikut untuk menjalankan migrasi database:

   ```bash
   php artisan migrate
   ```

6. **Seed Database**

   Untuk mengisi data awal pada database, jalankan perintah berikut:

   ```bash
   php artisan db:seed --class=ProductSeeder
   ```

7. **Menjalankan Aplikasi**

   Jalankan perintah berikut untuk memulai server aplikasi:

   ```bash
   php artisan serve
   ```

   Akses aplikasi di browser melalui URL:

   ```text
   http://localhost:8000
   ```

## Catatan

  - Pastikan MySQL server sudah berjalan sebelum menjalankan migrasi.
  - Jika kamu mengubah nama database atau konfigurasi lainnya, jangan lupa memperbarui file .env.


## Requirements Test

berikut penjelasan untuk setiap point reqruitment:

1. **Membuat Sistem CRUD**
   
   CRUD untuk data produk dapat diakses mellalui menu Products pada sidebar, atau dapat diakses melalui endpoint berikut:

   - Read Products
      ```url
      http://127.0.0.1:8000/products
      ```
   - Create Products
      ```url
      http://127.0.0.1:8000/products/add
      ```
   - Update Products
      ```url
      http://127.0.0.1:8000/products/edit/{productId}
      ```
   - Delete Products
      ```url
      http://127.0.0.1:8000/products/{productId}
      ```


2. **Integrasi Fitur Pesanan Menggunakan jQuery**

   Fitur pemesanan barang dapat di akses pada menu Order pada sidebar lalu klik tombol Create New Order, atau dapat diakses melalui endpoint berikut:

   ```url
   http://127.0.0.1:8000/order/create
   ```

3. **Optimasi Query MySQL**

   Untuk query SQL yang digunakan untuk optimasi menampilkan total rupiah dari produk yang dibeli konsumen dalam 1 hari dapat dilihat pada file "Query SQL.sql", atau sebagai berikut:

   ```sql
   SELECT
      o.id AS order_id,
      o.order_date,
      oi.product_id,
      oi.quantity,
      oi.price
   FROM
      orders o
   JOIN
      order_items oi ON o.id = oi.order_id
   WHERE
      o.order_date = '2024-08-30'; /*ganti dengan tanggal yang diinginkan*/
   ```

4. **Implementasi DataTables dengan Server-side Processing**

   Fitur untuk menampilkan data pembelian konsumen dapat di akses pada menu Order pada sidebar , atau dapat diakses melalui endpoint berikut:

   ```url
   http://127.0.0.1:8000/order
   ```
