# Katalog Buku Laravel

Project ini merupakan aplikasi sederhana **Katalog Buku** menggunakan Laravel. Project dibuat untuk praktikum **Pengembangan Aplikasi Web Lanjut** dengan materi CRUD dan Validasi Data.

## Fitur

Aplikasi ini memiliki beberapa fitur utama:

* Menampilkan daftar buku
* Melihat detail buku
* Menambahkan buku
* Mengedit buku
* Menghapus buku
* Validasi data
* Validasi ISBN
* Menampilkan pesan error
* Menampilkan pesan berhasil setelah proses CRUD

## Teknologi yang Digunakan

* PHP
* Laravel
* Blade
* MySQL
* HTML
* Git & GitHub

## Struktur Utama

Beberapa file yang digunakan dalam project:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── BookController.php
│   └── Requests/
│       ├── StoreBookRequest.php
│       └── UpdateBookRequest.php
│
├── Models/
│   └── Book.php
│
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    └── books/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php

routes/
└── web.php
```

## CRUD

Project ini menggunakan konsep CRUD.

### 1. Create

Create digunakan untuk menambahkan data buku baru.

Ketika pengguna membuka halaman tambah buku, method `create()` pada `BookController` akan menampilkan form.

```php
public function create()
{
    return view('books.create');
}
```

Setelah form dikirim, data diproses oleh method `store()`.

```php
public function store(StoreBookRequest $request)
{
    Book::create($request->validated());

    return redirect()
        ->route('books.index')
        ->with('success', 'Buku berhasil ditambahkan.');
}
```

Data tidak langsung disimpan, tetapi diperiksa terlebih dahulu melalui validation.

### 2. Read

Read digunakan untuk menampilkan data buku.

Method `index()` digunakan untuk menampilkan daftar buku:

```php
public function index()
{
    $books = Book::latest()->get();

    return view('books.index', compact('books'));
}
```

Sedangkan `show()` digunakan untuk melihat detail satu buku:

```php
public function show(Book $book)
{
    return view('books.show', compact('book'));
}
```

### 3. Update

Update digunakan untuk mengubah data buku.

Method `edit()` digunakan untuk menampilkan form edit:

```php
public function edit(Book $book)
{
    return view('books.edit', compact('book'));
}
```

Kemudian `update()` digunakan untuk menyimpan perubahan:

```php
public function update(UpdateBookRequest $request, Book $book)
{
    $book->update($request->validated());

    return redirect()
        ->route('books.index')
        ->with('success', 'Buku berhasil diperbarui.');
}
```

### 4. Delete

Delete digunakan untuk menghapus buku.

```php
public function destroy(Book $book)
{
    $book->delete();

    return redirect()
        ->route('books.index')
        ->with('success', 'Buku berhasil dihapus.');
}
```

Sebelum dihapus, pengguna juga mendapatkan konfirmasi dari browser.

## Resource Route

Project menggunakan resource route:

```php
Route::resource('books', BookController::class);
```

Dengan satu route tersebut, Laravel menyediakan route untuk proses CRUD, yaitu:

| Method    | URL                  | Fungsi                  |
| --------- | -------------------- | ----------------------- |
| GET       | `/books`             | Menampilkan daftar buku |
| GET       | `/books/create`      | Menampilkan form tambah |
| POST      | `/books`             | Menyimpan buku          |
| GET       | `/books/{book}`      | Menampilkan detail      |
| GET       | `/books/{book}/edit` | Menampilkan form edit   |
| PUT/PATCH | `/books/{book}`      | Mengubah buku           |
| DELETE    | `/books/{book}`      | Menghapus buku          |

Route dapat dilihat dengan perintah:

```bash
php artisan route:list --path=books
```

## Validation

Validation digunakan untuk memastikan data yang dimasukkan sesuai dengan aturan yang dibuat.

Pada project ini digunakan:

* `StoreBookRequest` untuk menambahkan buku
* `UpdateBookRequest` untuk mengedit buku

Contoh aturan validation:

```php
'title' => ['required', 'string', 'max:255'],
'author' => ['required', 'string', 'max:150'],
'year' => ['required', 'integer', 'between:1900,2100'],
```

Artinya:

* Judul wajib diisi dan maksimal 255 karakter.
* Penulis wajib diisi dan maksimal 150 karakter.
* Tahun wajib berupa angka dan berada pada rentang 1900–2100.

Jika data tidak sesuai, data tidak akan disimpan dan pesan error akan ditampilkan pada form.

## CSRF

Pada form yang mengirim data digunakan:

```php
@csrf
```

CSRF digunakan sebagai perlindungan pada request form.

Contohnya:

```php
<form action="{{ route('books.store') }}" method="POST">
    @csrf
```

CSRF berbeda dengan validation. CSRF digunakan untuk keamanan request, sedangkan validation digunakan untuk memeriksa isi data.

## Method Spoofing

Form HTML pada dasarnya menggunakan GET dan POST. Karena update membutuhkan PUT dan delete membutuhkan DELETE, Laravel menggunakan method spoofing.

Untuk update:

```php
@method('PUT')
```

Untuk delete:

```php
@method('DELETE')
```

Contoh:

```php
<form method="POST">
    @csrf
    @method('PUT')
</form>
```

Dengan cara tersebut Laravel dapat mengenali request sebagai PUT.

## Mass Assignment

Pada model `Book` digunakan `$fillable`:

```php
protected $fillable = [
    'title',
    'author',
    'year',
    'isbn',
];
```

`$fillable` digunakan untuk menentukan field yang boleh diisi menggunakan `create()` atau `update()`.

Data yang digunakan untuk `create()` dan `update()` juga berasal dari hasil validation.

## Error dan Old Input

Jika validation gagal, pesan error ditampilkan menggunakan:

```php
@error('title')
    <div class="error">{{ $message }}</div>
@enderror
```

Project juga menggunakan `old()` agar data yang sebelumnya sudah dimasukkan tidak langsung hilang ketika terjadi error.

Contohnya pada form tambah:

```php
value="{{ old('title') }}"
```

Pada form edit:

```php
value="{{ old('title', $book->title) }}"
```

Jadi, jika validation gagal, pengguna tidak perlu mengisi ulang semua data.

## Flash Message

Setelah proses berhasil, aplikasi memberikan pesan kepada pengguna.

Contohnya:

```php
->with('success', 'Buku berhasil ditambahkan.');
```

Pesan tersebut kemudian ditampilkan pada halaman menggunakan:

```php
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif
```

Flash message digunakan setelah proses:

* Tambah buku
* Edit buku
* Hapus buku

## ISBN

Pada bagian challenge modul, project ditambahkan field ISBN.

ISBN memiliki aturan:

* Wajib diisi
* Harus unik
* Ditampilkan pada form tambah
* Ditampilkan pada form edit
* Ditambahkan ke `$fillable`
* Divalidasi pada `StoreBookRequest`
* Divalidasi pada `UpdateBookRequest`

Pada saat edit, ISBN milik buku yang sedang diedit tetap boleh digunakan oleh buku tersebut. Namun, ISBN yang sudah digunakan oleh buku lain tidak boleh digunakan kembali.

## Alur Sederhana Aplikasi

Secara sederhana, alur aplikasi adalah:

```text
User
 ↓
Route
 ↓
Controller
 ↓
Validation
 ↓
Model
 ↓
Database
 ↓
View / Redirect
```

Contohnya ketika menambahkan buku:

```text
Form Tambah Buku
       ↓
POST /books
       ↓
StoreBookRequest
       ↓
Validation
       ↓
Book::create()
       ↓
Database
       ↓
Kembali ke Daftar Buku
       ↓
Flash Message
```

Jika validation gagal:

```text
Form
 ↓
Validation
 ↓
Gagal
 ↓
Kembali ke Form
 ↓
Error ditampilkan
 ↓
Old Input tetap ada
```

## Cara Menjalankan Project

Setelah project sudah tersedia, jalankan:

```bash
composer install
```

Kemudian atur konfigurasi database pada file `.env`.

Setelah database siap, jalankan:

```bash
php artisan migrate
```

Kemudian jalankan server Laravel:

```bash
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000/books
```

## Kesimpulan

Project ini dibuat untuk menerapkan materi CRUD dan validasi pada Laravel.

Selain CRUD, project juga menerapkan:

* Resource Controller
* Resource Route
* Eloquent
* Form Request
* Validation
* CSRF
* Method Spoofing
* Mass Assignment
* Error Feedback
* Old Input
* Flash Message
* Validasi ISBN

Dengan penerapan tersebut, proses pengelolaan data buku dapat dilakukan melalui fitur tambah, tampil, edit, dan hapus dengan validasi dan feedback kepada pengguna.
