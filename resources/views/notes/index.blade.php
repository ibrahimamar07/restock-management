@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Catatan — {{ $item->itemName }}</h3>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('items.notes.store', $item->idItem) }}">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" placeholder="Tulis catatan..."></textarea>
        </div>
        <button class="btn btn-primary mt-2">Simpan Catatan</button>
    </form>

    <hr>

    <ul class="list-group">
        @foreach($notes as $note)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ optional($note->user)->name ?? 'Pengguna' }}</strong>
                    <div class="small text-muted">{{ $note->created_at->diffForHumans() }}</div>
                    <div class="mt-2">{{ $note->content }}</div>
                </div>
                @if(optional($note->user)->id === auth()->id())
                    <form method="POST" action="{{ route('items.notes.destroy', [$item->idItem, $note->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
