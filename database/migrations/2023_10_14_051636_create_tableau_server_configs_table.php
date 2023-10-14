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
        Schema::create('tableau_server_configs', function (Blueprint $table) {
            $table->id();
            $table->string('server_url');
            $table->string('server_version');
            $table->string('site_name');
            $table->text('client_id');
            $table->text('client_secret');
            $table->dateTime('client_exp_date');
            $table->text('access_name');
            $table->text('access_token');
            $table->dateTime('pa_exp_date');
            $table->string('data_upload_connection_username');
            $table->string('data_upload_connection_password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tableau_server_configs');
    }
};
