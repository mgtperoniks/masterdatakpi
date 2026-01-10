@extends('layouts.master')

@section('title', isset($heatNumber) ? 'Edit Heat Number' : 'Add Heat Number')

@section('content')

    <div class="mb-3">
        <a href="{{ route('master.heat-numbers.index') }}" class="text-decoration-none">
            &larr; Back to List
        </a>
    </div>

    <div class="card max-w-lg">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ isset($heatNumber) ? 'Edit Heat Number' : 'Add New Heat Number' }}</h5>
        </div>
        <div class="card-body">

            <form
                action="{{ isset($heatNumber) ? route('master.heat-numbers.update', $heatNumber) : route('master.heat-numbers.store') }}"
                method="POST">
                @csrf
                @if(isset($heatNumber))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Heat Number (Unique Code)</label>
                    <input type="text" name="heat_number" class="form-control @error('heat_number') is-invalid @enderror"
                        value="{{ old('heat_number', $heatNumber->heat_number ?? '') }}" placeholder="e.g. HN-2026-001"
                        required>
                    @error('heat_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Item / Product</label>
                    <select name="item_code" class="form-select @error('item_code') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Select Item --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->code }}" {{ (old('item_code', $heatNumber->item_code ?? '') == $item->code) ? 'selected' : '' }}>
                                {{ $item->code }} - {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('item_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Produksi</label>
                    <input type="text" name="kode_produksi"
                        class="form-control @error('kode_produksi') is-invalid @enderror"
                        value="{{ old('kode_produksi', $heatNumber->kode_produksi ?? '') }}"
                        placeholder="Optional batch code">
                    @error('kode_produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Cor Qty</label>
                    <input type="number" name="cor_qty" class="form-control @error('cor_qty') is-invalid @enderror"
                        value="{{ old('cor_qty', $heatNumber->cor_qty ?? 0) }}" min="0" required>
                    @error('cor_qty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ (old('status', $heatNumber->status ?? 'active') == 'active') ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (old('status', $heatNumber->status ?? 'active') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('master.heat-numbers.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($heatNumber) ? 'Update Heat Number' : 'Save Heat Number' }}
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection