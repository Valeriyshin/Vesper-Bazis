<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('template_strings', function(Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('key');
            $table->text('value_ru')->nullable()->default(null);
            $table->text('value_kk')->nullable()->default(null);
            $table->string('comment')
                ->nullable()->default(null);
            $table->string('hint')
                ->nullable()->default(null);
            $table->unique(['module', 'key']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_strings');
    }
};
