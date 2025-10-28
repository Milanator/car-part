<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('registration_number', 100)->nullable()->index()->unique();
            $table->boolean('is_registered')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
    }
};
