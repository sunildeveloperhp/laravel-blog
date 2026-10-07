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
    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Featured image</label>

    @if ($post->featured_image_url)
        <div class="mb-3 flex items-start gap-4">
            <img src="{{ $post->featured_image_url }}" alt="Current featured image"
                 class="w-40 h-24 object-cover rounded-md border border-gray-200">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300">
                Remove current image
            </label>
        </div>
    @endif

    <input type="file" id="featured_image" name="featured_image" accept="image/jpeg,image/png,image/webp"
           class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100">
    <p class="mt-1 text-xs text-gray-500">JPG, PNG or WebP, up to 2 MB. Choosing a new file replaces the current one.</p>
    @error('featured_image')
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

<div>
    <span class="block text-sm font-medium text-gray-700 mb-2">Tags <span class="text-gray-400 font-normal">(up to 5)</span></span>

    <div class="flex flex-wrap gap-x-6 gap-y-2">
        @foreach ($tags as $tag)
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                       @checked(in_array($tag->id, old('tags', $post->tags->pluck('id')->all())))
                       class="rounded border-gray-300">
                {{ $tag->name }}
            </label>
        @endforeach
    </div>

    @error('tags')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @error('tags.*')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>