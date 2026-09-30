@extends('layouts.app')

@section('content')
    <h1>Tambah Buku</h1>

    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div>
            <label>Judul</label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
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
                value="{{ old('author') }}"
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
                value="{{ old('year') }}"
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
                value="{{ old('isbn') }}"
            >

            @error('isbn')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Simpan</button>

        <a href="{{ route('books.index') }}">Batal</a>
    </form>
@endsection