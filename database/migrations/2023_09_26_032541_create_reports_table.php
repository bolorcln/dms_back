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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('view_url');
            $table->foreignId('sub_menu_id')->constrained('sub_menus')->restrictOnDelete();

            $table->boolean('manual_data_upload_flag');
            $table->text('data_source_url')->nullable();
            $table->foreignId('report_upload_type_id')->nullable()->constrained('report_upload_types');

            $table->boolean('support_phone')->default(false);
            $table->boolean('support_desktop')->default(false);
            $table->boolean('support_tablet')->default(false);
            $table->boolean('hide_tabs')->default(false);
            $table->boolean('show_toolbar')->default(false); 
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->boolean('is_interactive')->default(false);
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
