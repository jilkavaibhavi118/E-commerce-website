@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="text-xl font-bold mb-4">Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Category -->
        <div class="mb-3">
            <label class="font-semibold">Category</label>
            <select id="category_id" name="category_id" class="select2 w-full">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subcategory -->
        <div class="mb-3">
            <label class="font-semibold">Subcategory</label>
            <select id="subcategory_id" name="subcategory_id" class="select2 w-full">
                <option value="">Loading...</option>
            </select>
        </div>

        <!-- Name -->
        <div class="mb-3">
            <label class="font-semibold">Product Name</label>
            <input type="text" value="{{ $product->name }}" name="name" class="w-full border p-2" required>
        </div>

        <!-- SKUs -->
        <h4 class="font-semibold mb-2">Product Variants</h4>
        <table class="w-full border" id="sku_table">
            <thead>
                <tr class="bg-gray-200">
                    <th>SKU</th>
                    <th>Attribute</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($product->skus as $i => $sku)
                <tr>
                    <td><input type="text" name="skus[{{ $i }}][sku]" value="{{ $sku->sku }}" class="border px-2 py-1 w-full" required></td>
                    <td><input type="text" name="skus[{{ $i }}][attribute]" value="{{ $sku->attribute }}" class="border px-2 py-1 w-full" required></td>
                    <td><input type="number" name="skus[{{ $i }}][stock]" value="{{ $sku->stock }}" class="border px-2 py-1 w-full" required></td>
                    <td><input type="number" step="0.01" name="skus[{{ $i }}][price]" value="{{ $sku->price }}" class="border px-2 py-1 w-full" required></td>
                    <td><button type="button" class="btn-remove-row bg-red-600 text-white px-2 rounded">x</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn-add-row mt-2 bg-blue-600 text-white px-3 py-1 rounded">+ Add Variant</button>

        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Update Product</button>

    </form>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function () {

    // Load subcategories for selected category
    let catId = $('#category_id').val();

    $.getJSON('/api/subcategories/by-category/' + catId, function(data){

        let html = '<option value="">Select Subcategory</option>';

        $.each(data, function(i, item){
            html += '<option value="' + item.id + '" '
                + (item.id == {{ $product->subcategory_id }} ? 'selected' : '')
                + '>' + item.name + '</option>';
        });

        $('#subcategory_id').html(html);
        $('#subcategory_id').trigger('change.select2');
    });

    // SKU row add
    let rowIndex = {{ count($product->skus) }};
    $(document).on('click', '.btn-add-row', function () {
        let html = `
            <tr>
                <td><input type="text" name="skus[${rowIndex}][sku]" class="border px-2 py-1 w-full" required></td>
                <td><input type="text" name="skus[${rowIndex}][attribute]" class="border px-2 py-1 w-full" required></td>
                <td><input type="number" name="skus[${rowIndex}][stock]" class="border px-2 py-1 w-full" required></td>
                <td><input type="number" step="0.01" name="skus[${rowIndex}][price]" class="border px-2 py-1 w-full" required></td>
                <td><button type="button" class="btn-remove-row bg-red-600 text-white px-2 rounded">x</button></td>
            </tr>
        `;
        $("#sku_table tbody").append(html);
        rowIndex++;
    });

    // Remove SKU row
    $(document).on('click', '.btn-remove-row', function () {
        $(this).closest('tr').remove();
    });

});
</script>
@endsection
