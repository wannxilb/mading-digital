<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('status')->default('published')->after('image');
            $table->text('review_note')->nullable()->after('status');
        });

        DB::table('posts')->where('is_published', true)->update(['status' => 'published']);
        DB::table('posts')->where('is_published', false)->update(['status' => 'draft']);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['status', 'review_note']);
        });
    }
};
