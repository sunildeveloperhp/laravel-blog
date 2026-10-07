<div>
    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
           @class([
               'w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
               'border-red-500' => $errors->has('title'),
               'border-gray-300' => ! $errors->has('title'),
           ])>
    @error('title')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
    <select id="category_id" name="category_id"
            @class([
                'w-full rounded-md border px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500',
                'border-red-500' => $errors->has('category_id'),
                'border-gray-300' => ! $errors->has('category_id'),
            ])>
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
    <textarea id="excerpt" name="excerpt" rows="2"
              @class([
                  'w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                  'border-red-500' => $errors->has('excerpt'),
                  'border-gray-300' => ! $errors->has('excerpt'),
              ])>{{ old('excerpt', $post->excerpt) }}</textarea>
    @error('excerpt')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body</label>
    <textarea id="body" name="body" rows="12"
              @class([
                  'w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                  'border-red-500' => $errors->has('body'),
                  'border-gray-300' => ! $errors->has('body'),
              ])>{{ old('body', $post->body) }}</textarea>
    @error('body')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>