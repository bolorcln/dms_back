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
        Schema::table('tableau_server_configs', function (Blueprint $table) {
            $table->string('secret_id')->after('data_upload_connection_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tableau_server_configs', function (Blueprint $table) {
            $table->dropColumn(['secret_id']);
        });
    }
};
