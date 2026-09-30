@extends('layouts.app')

@section('content')
    <h1>Daftar Buku</h1>

    <a href="{{ route('books.create') }}">Tambah Buku</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->isbn }}</td>

                    <td>
                        <a href="{{ route('books.show', $book) }}">
                            Detail
                        </a>

                        |

                        <a href="{{ route('books.edit', $book) }}">
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route('books.destroy', $book) }}"
                            onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        Belum ada data buku.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection