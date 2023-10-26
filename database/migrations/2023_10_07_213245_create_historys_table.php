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
        Schema::create('historys', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('isdeleted')->default(0);
            $table->string('remark', 200)->nullable();
            $table->string('insertBy', 200)->nullable();
            $table->dateTime('inserttime');
            $table->string('updateBy', 200)->nullable();
            $table->dateTime('updatetime')->nullable();
            $table->string('deleteBy', 200)->nullable();
            $table->dateTime('deletetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
