<?php

use Altenic\MaybeCms\Models\PostType;
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
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->foreignIdFor(PostType::class)->nullable()->constrained('post_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(PostType::class, 'related_post_type_id')->nullable()->constrained('post_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('relations');
    }
};
