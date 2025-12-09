@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $product->name }}</h5>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <dl class="row mb-3">
                <dt class="col-sm-3">Category</dt>
                <dd class="col-sm-9">{{ $product->category?->name ?? '—' }}</dd>

                <dt class="col-sm-3">Subcategory</dt>
                <dd class="col-sm-9">{{ $product->subCategory?->name ?? '—' }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $product->description ?? '—' }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if($product->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </dd>
            </dl>

            <h6>Images</h6>
            <div class="d-flex flex-wrap gap-2 mb-3">
                @forelse($product->images as $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image" width="120" class="img-thumbnail">
                @empty
                    <p class="text-muted mb-0">No images uploaded.</p>
                @endforelse
            </div>

            <h6>SKUs</h6>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Attribute</th>
                            <th>Stock</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->skus as $sku)
                            <tr>
                                <td>{{ $sku->sku }}</td>
                                <td>{{ $sku->attribute }}</td>
                                <td>{{ $sku->stock }}</td>
                                <td>₹ {{ number_format($sku->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No variants.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl p-6">
    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-xl font-semibold mb-4">{{ $product->name }}</h2>

        <p><strong>Category:</strong> {{ $product->category->name }}</p>
        <p><strong>Subcategory:</strong> {{ $product->subcategory->name }}</p>
        <p><strong>Price:</strong> ${{ $product->price }}</p>
        <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
        <p><strong>Description:</strong></p>
        <p>{{ $product->description }}</p>

        <h4 class="mt-4 font-semibold">Images</h4>
        <div class="flex gap-2 flex-wrap">
            @foreach($product->images as $img)
                <img src="{{ asset('storage/'.$img->image_path) }}" width="100" class="border rounded">
            @endforeach
        </div>

        <h4 class="mt-4 font-semibold">Variants</h4>
        <table class="w-full border">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Attribute</th>
                    <th>Stock</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->skus as $sku)
                <tr>
                    <td>{{ $sku->sku }}</td>
                    <td>{{ $sku->attribute }}</td>
                    <td>{{ $sku->stock }}</td>
                    <td>{{ $sku->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
