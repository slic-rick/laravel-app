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

        Schema::create('follows',function (Blueprint $table) {

            $table -> id();
            $table -> timestamps();
            $table -> foreignId('user_id') -> constrained();
            $table -> unsignedBigInteger('followedUser');
            $table -> foreign('followedUser') -> references('id')-> on('users'); 
        });
        //

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
