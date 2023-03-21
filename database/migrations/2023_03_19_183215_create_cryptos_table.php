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
        Schema::create('cryptos', function (Blueprint $table) {
            $table->id();
            $table->integer('crypto_id');
            $table->text('name');
            $table->text('symbol');
            $table->decimal('price', 8, 2);
            $table->decimal('percent_change_1h', 8, 2);
            $table->decimal('percent_change_24h', 8, 2);
            $table->decimal('percent_change_7d', 8, 2);
            $table->double('market_cap', 12 );
            $table->double('volume_24h', 12 );
            $table->double('circulating_supply', 12 );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryptos');
    }
};
