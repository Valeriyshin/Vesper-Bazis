<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('apartments', function(Blueprint $table) {
            $table->id();
            $table->string('blockName')
                ->nullable()->default(null);
            $table->string('number', 31)
                ->nullable()->default(null);
            $table->decimal('area', 6, 1)
                ->default(0);
            $table->decimal('meterPrice', 12, 2)
                ->nullable()->default(null);
            $table->decimal('totalPrice', 16, 2)
                ->default(0);
            $table->string('apartmentCode', 31)
                ->nullable()->default(null);
            $table->string('status', 31)
                ->nullable()->default(null);
            $table->tinyInteger('floor')
                ->default(0);
            $table->tinyInteger('rooms')
                ->default(0);
            $table->string('crm_id', 36)
                ->unique()
                ->nullable()->default(null);
            $table->boolean('isApartmentReserved')
                ->default(false);
            $table->boolean('hasJointVentureAgreement')
                ->default(false);
            $table->boolean('hasMortgage')
                ->default(false);
            $table->text('images')
                ->default('[]');
            $table->text('payload')
                ->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
