<?php

use Altenic\MaybeCms\Models\Post;
use Altenic\MaybeCms\Models\Relation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_post', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Post::class, 'related_post_id')->nullable()->constrained('posts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Relation::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_post');
    }
};
