<div class="mb-3">
    <label class="block font-medium mb-1">Code</label>
    <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Type</label>
    <select name="type" class="w-full border p-2 rounded">
        <option value="percentage" {{ old('type', $coupon->type ?? '')=='percentage'?'selected':'' }}>Percentage</option>
        <option value="fixed" {{ old('type', $coupon->type ?? '')=='fixed'?'selected':'' }}>Fixed</option>
    </select>
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Value</label>
    <input type="number" name="value" value="{{ old('value', $coupon->value ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Min Cart Value</label>
    <input type="number" name="min_cart_value" value="{{ old('min_cart_value', $coupon->min_cart_value ?? 0) }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Max Uses</label>
    <input type="number" name="max_uses" value="{{ old('max_uses', $coupon->max_uses ?? 1) }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Max Uses Per User</label>
    <input type="number" name="max_uses_user" value="{{ old('max_uses_user', $coupon->max_uses_user ?? 1) }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Start Date</label>
    <input type="date" name="start_date" value="{{ old('start_date', $coupon->start_date ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">End Date</label>
    <input type="date" name="end_date" value="{{ old('end_date', $coupon->end_date ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Status</label>
    <select name="status" class="w-full border p-2 rounded">
        <option value="1" {{ old('status', $coupon->status ?? 1)==1?'selected':'' }}>Active</option>
        <option value="0" {{ old('status', $coupon->status ?? 1)==0?'selected':'' }}>Inactive</option>
    </select>
</div>
