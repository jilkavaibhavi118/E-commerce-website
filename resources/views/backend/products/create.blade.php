@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="text-xl font-bold mb-4">Create Product</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="crudForm">
        @csrf

         <!-- Product Name -->
        <div class="mb-3">
            <label class="font-semibold">Product Name</label>
            <input type="text" name="name" class="w-full border p-2" required>
        </div>

        <!-- Product Slug -->
        <div class="mb-3">
              <label class="font-semibold">Product Slug</label>
              <input type="text" name="slug" class="w-full border p-2" required>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="font-semibold">Category</label>
            <select id="category_id" name="category_id" class="select2 w-full">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subcategory -->
        <div class="mb-3">
            <label class="font-semibold">Subcategory</label>
            <select id="subcategory_id" name="subcategory_id" class="select2 w-full">
                <option value="">Select Category First</option>
            </select>
        </div>

         <!-- Brand -->
         <div class="mb-3">
            <label class="font-semibold">Brand</label>
            <select id="brand_id" name="brand_id" class="select2 w-full">
                <option value="">Select Brand</option>
            </select>
        </div>

        <!-- Product Description -->
<div class="mb-3">
    <label class="font-semibold">Description</label>
    <textarea name="description" class="w-full border p-2" rows="4"></textarea>
</div>

<!-- Product Status -->
<div class="mb-3">
    <label class="font-semibold">Status</label>
    <select name="status" class="w-full border p-2">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>
</div>

<!-- Product Image -->
<div class="mb-3">
    <label class="font-semibold">Product Image</label>
    <input type="file" name="images[]" class="w-full border p-2" multiple>

</div>



        <!-- SKU Table -->
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
                <tr>
                    <td><input type="text" name="skus[0][sku]" class="border px-2 py-1 w-full" required></td>
                    <td><input type="text" name="skus[0][attribute]" class="border px-2 py-1 w-full" required></td>
                    <td><input type="number" name="skus[0][stock]" class="border px-2 py-1 w-full" required></td>
                    <td><input type="number" step="0.01" name="skus[0][price]" class="border px-2 py-1 w-full" required></td>
                    <td><button type="button" class="btn-add-row bg-blue-600 text-white px-3 py-1 rounded">+</button></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" id="crudFormSave" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Save Product</button>

    </form>

</div>
@endsection



@section('scripts')
<script>
$(document).ready(function() {

    // Load subcategories using API
    $('#category_id').on('change', function () {

        let catId = $(this).val();
        $('#subcategory_id').html('<option>Loading...</option>');

        if (!catId) {
            $('#subcategory_id').html('<option value="">Select Category First</option>');
            return;
        }

        $.getJSON('/api/subcategories/by-category/' + catId, function(data){

            let html = '<option value="">Select Subcategory</option>';

            $.each(data, function(i, item){
                html += '<option value="'+item.id+'">'+item.name+'</option>';
            });

            $('#subcategory_id').html(html);

            // Reinitialize Select2
            $('#subcategory_id').select2();

        });


    });

     // brand dropdown
     $('#brand_id').select2({
            placeholder: 'Select Brand',
            allowClear: true,
            ajax: {
                url: '{{ route("brands.select2") }}',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { searchTerm: params.term };
                },
                processResults: function(data) {
                    return { results: data };
                }
            }
        });

    // SKU row add
    let rowIndex = 1;
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
