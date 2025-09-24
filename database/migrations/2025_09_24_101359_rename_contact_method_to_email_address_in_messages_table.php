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
        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('contact_method', 'email_address');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('email_address')->change();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('email_address', 'contact_method');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->text('contact_method')->change(); // change back to original type if it was text
        });
    }
};
