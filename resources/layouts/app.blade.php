<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>@yield('title', 'Katalog Buku')</title> 
    <style> 
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 32px auto; padding: 0 16px; } 
        nav { margin-bottom: 24px; } 
        a { margin-right: 8px; } 
        input { display: block; width: 100%; max-width: 480px; padding: 8px; margin: 4px 0 10px; } 
        .error { color: #b91c1c; } 
        .success { color: #166534; } 
        table { width: 100%; border-collapse: collapse; } 
        th, td { text-align: left; padding: 8px; border: 1px solid #d1d5db; } 
        form.inline { display: inline; } 
    </style> 
</head> 
<body> 
    <nav> 
        <a href="{{ route('books.index') }}">Daftar Buku</a> 
        <a href="{{ route('books.create') }}">Tambah Buku</a> 
    </nav> 
 
    @yield('content') 
</body> 
</html> 