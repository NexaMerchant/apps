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
        Schema::create('apps_version', function (Blueprint $table) {
            $table->id();
            $table->string('version')->comment('version');
            $table->string('description')->comment('description');
            $table->integer("app_id")->comment("app id");
            $table->enum("status",['enable','disable','pending'])->default("enable")->comment("status");
            $table->timestamps();

            // index
            $table->index('app_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_version');
    }
};
