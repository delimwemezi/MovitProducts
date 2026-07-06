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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->longBlob('image_data');                    // ← Binary image data stored in DB
            $table->string('mime_type');                       // e.g., 'image/jpeg', 'image/png'
            $table->string('original_filename');               // Original file name
            $table->unsignedBigInteger('file_size');          // Size in bytes
            $table->boolean('is_cloudinary')->default(false); // Track if migrated from Cloudinary
            $table->string('cloudinary_url')->nullable();     // Keep original URL for reference
            $table->timestamps();

            // Index for faster lookups
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
