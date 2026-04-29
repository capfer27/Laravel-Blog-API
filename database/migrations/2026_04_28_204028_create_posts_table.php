<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\PostStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');

            $table->enum('status', array_column(PostStatus::cases(), 'value'))
                    ->default(PostStatus::MODERATION->value);

            $table->timestamp('published_at')->nullable();
            $table->timestamp('moderated_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
