<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Support\BlogCache;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostService
{
    // Create a post for an author, with an optional image and tags
    public function create(User $author, array $data, ?UploadedFile $image, array $tagIds): Post
    {
        $data['published_at'] = now();

        if ($image) {
            $data['featured_image'] = $image->store('posts', 'public');
        }

        // Creating through the relationship fills user_id automatically
        $post = $author->posts()->create($data);
        $post->tags()->sync($tagIds);
        BlogCache::flush();

        return $post;
    }

    // Update a post. $tagIds = null means "don't touch the tags".
    public function update(Post $post, array $data, ?UploadedFile $image, bool $removeImage, ?array $tagIds): Post
    {
        if ($image) {
            // A new image was uploaded: delete the old file, then save the new one
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $image->store('posts', 'public');
        } elseif ($removeImage && $post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
            $data['featured_image'] = null;
        }

        $post->update($data);

        if ($tagIds !== null) {
            $post->tags()->sync($tagIds);
            BlogCache::flush();   // tag counts may have changed even if nothing else did
        }

        return $post;
    }
}
