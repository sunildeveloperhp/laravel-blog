<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // List endpoints leave out the full text to keep responses small
        $isList = $request->routeIs('api.v1.posts.index', 'api.v1.my-posts.index');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->when(! $isList, $this->body),

            'featured_image_url' => $this->featured_image_url,
            'published_at' => $this->published_at?->toIso8601String(),
            'comments_count' => $this->whenCounted('comments'),

            // Related data, only if the controller loaded it
            'author' => new AuthorResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),

            // Link to the post on the website
            'url' => route('posts.show', $this->resource),
        ];
    }
}
