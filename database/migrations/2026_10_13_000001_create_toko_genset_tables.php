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
        // Table: brands
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Table: products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('kategori')->default('genset'); // genset, forklift, lighting_tower
            $table->string('brand')->nullable(); // Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde
            $table->decimal('kapasitas_kva', 10, 2)->nullable();
            $table->string('kapasitas_label')->nullable(); // e.g. "100 KVA", "5000W", "3.5 Ton"
            $table->string('tipe')->default('silent'); // silent, open
            $table->text('deskripsi')->nullable();
            $table->json('spesifikasi')->nullable();
            $table->string('foto_utama')->nullable();
            $table->json('galeri')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table: gallery_items
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('caption')->nullable();
            $table->string('tipe')->default('gudang'); // gudang, sold
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Table: settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
    }
};
