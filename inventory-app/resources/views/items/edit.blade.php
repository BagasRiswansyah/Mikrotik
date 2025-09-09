@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-edit"></i> Edit Item: {{ $item->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Item Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $item->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Item Code *</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                        name="code" value="{{ old('code', $item->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3">{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity *</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ old('quantity', $item->quantity) }}" min="0"
                                        required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (Rp) *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price', $item->price) }}" step="0.01" min="0"
                                        required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror"
                                        id="category" name="category" value="{{ old('category', $item->category) }}"
                                        list="categoryList" required>
                                    <datalist id="categoryList">
                                        <option value="Electronics">
                                        <option value="Furniture">
                                        <option value="Office Supplies">
                                        <option value="Tools">
                                        <option value="Books">
                                        <option value="Clothing">
                                        <option value="Food & Beverage">
                                        <option value="Healthcare">
                                        <option value="Automotive">
                                        <option value="Sports">
                                    </datalist>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        id="location" name="location" value="{{ old('location', $item->location) }}"
                                        list="locationList">
                                    <datalist id="locationList">
                                        <option value="Warehouse A">
                                        <option value="Warehouse B">
                                        <option value="Storage Room 1">
                                        <option value="Storage Room 2">
                                        <option value="Main Office">
                                        <option value="Branch Office">
                                    </datalist>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="purchase_date" class="form-label">Purchase Date</label>
                                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                        id="purchase_date" name="purchase_date"
                                        value="{{ old('purchase_date', $item->purchase_date ? $item->purchase_date->format('Y-m-d') : '') }}">
                                    @error('purchase_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Supplier</label>
                                    <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                        id="supplier" name="supplier" value="{{ old('supplier', $item->supplier) }}"
                                        list="supplierList">
                                    <datalist id="supplierList">
                                        <option value="PT Supplier A">
                                        <option value="CV Supplier B">
                                        <option value="Toko Supplier C">
                                        <option value="UD Supplier D">
                                        <option value="PT Global Supply">
                                        <option value="CV Mitra Jaya">
                                    </datalist>
                                    @error('supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Current Status Display -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Current Status</label>
                                    <div class="form-control-plaintext">
                                        <span
                                            class="badge bg-{{ $item->status == 'available' ? 'success' : ($item->status == 'low_stock' ? 'warning' : 'danger') }} fs-6">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </div>
                                    <small class="text-muted">Status will be automatically updated based on quantity</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Value</label>
                                    <div class="form-control-plaintext">
                                        <strong class="text-success">Rp
                                            {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
                                    </div>
                                    <small class="text-muted">Quantity × Price</small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <a href="{{ route('items.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ route('items.show', $item) }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Information Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6><i class="fas fa-info-circle"></i> Item Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $item->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Last Updated:</strong> {{ $item->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Status Rules:</strong><br>
                                • Available: Quantity > 5<br>
                                • Low Stock: Quantity 1-5<br>
                                • Out of Stock: Quantity = 0
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Calculations -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const priceInput = document.getElementById('price');

            function updateTotalValue() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const total = quantity * price;

                // Update total value display (if exists)
                const totalValueElement = document.querySelector('.text-success strong');
                if (totalValueElement) {
                    totalValueElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
                }
            }

            // Add event listeners
            quantityInput.addEventListener('input', updateTotalValue);
            priceInput.addEventListener('input', updateTotalValue);
        });
    </script>
@endsection