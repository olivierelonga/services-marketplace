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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('email'); // Adjust position if needed
            $table->boolean('is_provider')->default(false)->after('hourly_rate');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['hourly_rate', 'is_provider']);
        });
    }
};
