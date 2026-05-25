<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progress_stages', function(Blueprint $table) {
            $table->id();
            $table->string('title_ru');
            $table->string('title_kk');
            $table->text('details_ru')
                ->nullable()->default(null);
            $table->text('details_kk')
                ->nullable()->default(null);
            $table->text('images')
                ->nullable()->default(null);
            $table->integer('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_stages');
    }
};
