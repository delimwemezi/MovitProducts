<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only modify if database is MySQL/MariaDB
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE product_images MODIFY image_data LONGBLOB');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE product_images MODIFY image_data BLOB');
        }
    }
};
