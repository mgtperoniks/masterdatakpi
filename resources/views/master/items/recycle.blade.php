@extends('layouts.master')

@section('title','Recycle Bin — Items')

@section('content')

<h4 class="mb-3">Recycle Bin — Items</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Deleted At</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->deleted_at }}</td>
                    <td class="text-end">
                        <form method="POST"
                              action="{{ route('master.items.restore',$item->id) }}"
                              class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">
                                Restore
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('master.items.forceDelete',$item->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Hapus permanen?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Delete Permanen
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Recycle Bin kosong
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
