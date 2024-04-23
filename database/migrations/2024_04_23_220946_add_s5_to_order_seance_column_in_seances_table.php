<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE seances MODIFY COLUMN order_seance ENUM('s1', 's2', 's3', 's4', 's5')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // In the down migration, you might revert the changes if necessary.
        // However, removing values from enums isn't common due to potential data loss.
    }
};
