<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pronunciations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Word::class)->constrained()->cascadeOnDelete();
            $table->text('path_audio');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pronunciations');
    }
};
