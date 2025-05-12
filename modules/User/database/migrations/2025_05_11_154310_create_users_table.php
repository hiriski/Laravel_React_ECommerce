<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Common\Enums\StatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('emailVerifiedAt')->nullable();
            $table->string('password')->nullable();
            $table->string('photoUrl')->nullable();
            $table->string('avatarTextColor', 36)->nullable();
            $table->enum('gender', ['male', 'female', 'none'])->nullable();
            $table->text('about')->nullable();
            $table->date('dateOfBirthday')->nullable();
            $table->unsignedTinyInteger('status')->default(StatusEnum::ACTIVE)->comment(
                StatusEnum::ACTIVE . '=' . 'Active' . ',' .
                    StatusEnum::INACTIVE . '=' . 'Inactive'
            );
            $table->string('rememberToken', 100)->nullable();
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
