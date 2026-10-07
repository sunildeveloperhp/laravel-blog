<div>
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required maxlength="50"
           @class([
               'w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
               'border-red-500' => $errors->has('name'),
               'border-gray-300' => ! $errors->has('name'),
           ])>
    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>