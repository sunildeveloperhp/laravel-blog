<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Used by the published() scope and by latest('published_at') on every public page
            $table->index('published_at');
        });

        Schema::table('comments', function (Blueprint $table) {
            // "Approved comments of this post": both columns are used together
            $table->index(['post_id', 'approved_at']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['post_id', 'approved_at']);
        });
    }
};
