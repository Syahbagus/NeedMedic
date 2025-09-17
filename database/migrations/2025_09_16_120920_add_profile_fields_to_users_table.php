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
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('email');
            $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('gender');
            $table->string('city')->nullable()->after('address');
            $table->string('contact_no')->nullable()->after('city');
            $table->string('paypal_id')->nullable()->after('contact_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'date_of_birth',
                'gender',
                'address',
                'city',
                'contact_no',
                'paypal_id',
            ]);
        });
    }
};
