<?php

use App\Models\User;
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
        Schema::create('favorite_gif', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('alias');
            //aqui tambien operaremos con string, dada la diferencia de la consigna con el API de giphy
            $table->string('gif_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_gif');
    }
};
