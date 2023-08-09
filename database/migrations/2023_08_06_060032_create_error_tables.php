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
        $tableName = 'error';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('error_type', 255);
            $table->string('request_method', 255);
            $table->string('request_uri', 1024);
            $table->string('request_params', 1024);
            $table->text('message');
            $table->string('file', 255);
            $table->integer('line');
            $table->text('trace');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
