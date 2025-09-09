@extends('layouts.app')

@section('title', 'Item Details')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-eye"></i> Item Details</h5>
                    <div>
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Item Code:</strong></td>
                                    <td>{{ $item->code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>{{ $item->category }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Quantity:</strong></td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Value:</strong></td>
                                    <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->status == 'available' ? 'success' : ($item->status == 'low_stock' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $item->location ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Purchase Date:</strong></td>
                                    <td>{{ $item->purchase_date ? $item->purchase_date->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td>{{ $item->supplier ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($item->description)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6><strong>Description:</strong></h6>
                                <p class="text-muted">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection