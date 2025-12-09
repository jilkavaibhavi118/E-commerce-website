<div class="mb-3">
    <label class="block font-medium mb-1">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $customer->name ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Email</label>
    <input type="email" name="email"
           value="{{ old('email', $customer->email ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div class="mb-3">
    <label class="block font-medium mb-1">Phone</label>
    <input type="text" name="phone"
           value="{{ old('phone', $customer->phone ?? '') }}"
           class="w-full border rounded p-2">
</div>

@if(!isset($customer))
<div class="mb-3">
    <label class="block font-medium mb-1">Password</label>
    <input type="password" name="password"
           class="w-full border rounded p-2">
</div>
@endif

<div class="mb-3">
    <label class="block font-medium mb-1">Status</label>
    <select name="status" class="w-full border rounded p-2">
        <option value="1" {{ old('status', $customer->status ?? 1)==1?'selected':'' }}>Active</option>
        <option value="0" {{ old('status', $customer->status ?? 1)==0?'selected':'' }}>Inactive</option>
    </select>
</div>
