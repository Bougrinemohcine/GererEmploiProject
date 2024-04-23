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
        Schema::table('formateur_module', function (Blueprint $table) {
            $table->string('status')->default('pending'); // Add the status column with a default value of 'pending'
        });
    }

    public function down()
    {
        Schema::table('formateur_module', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove the status column if you need to rollback
        });
    }

};
