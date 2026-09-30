@extends('layouts.app')

@section('content')
    <h1>Detail Buku</h1>

    <p>
        <strong>Judul:</strong>
        {{ $book->title }}
    </p>

    <p>
        <strong>Penulis:</strong>
        {{ $book->author }}
    </p>

    <p>
        <strong>Tahun:</strong>
        {{ $book->year }}
    </p>

    <p>
        <strong>ISBN:</strong>
        {{ $book->isbn }}
    </p>

    <a href="{{ route('books.index') }}">Kembali</a>
@endsection