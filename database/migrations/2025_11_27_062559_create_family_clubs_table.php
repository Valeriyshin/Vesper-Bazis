<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('family_clubs', function(Blueprint $table) {
            $table->id();
            $table->integer('weight')
                ->default(100);
            $table->string('image');
            $table->text('text_ru')
                ->nullable()->default(null);
            $table->text('text_kk')
                ->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_clubs');
    }
};
