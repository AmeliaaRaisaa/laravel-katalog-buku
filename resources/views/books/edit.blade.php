@extends('layouts.app')

@section('content')
    <h1>Edit Buku</h1>

    <form method="POST" action="{{ route('books.update', $book) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Judul</label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $book->title) }}"
            >

            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Penulis</label>
            <input
                type="text"
                name="author"
                value="{{ old('author', $book->author) }}"
            >

            @error('author')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Tahun</label>
            <input
                type="number"
                name="year"
                value="{{ old('year', $book->year) }}"
            >

            @error('year')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>ISBN</label>
            <input
                type="text"
                name="isbn"
                value="{{ old('isbn', $book->isbn) }}"
            >

            @error('isbn')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Update</button>

        <a href="{{ route('books.index') }}">Batal</a>
    </form>
@endsection