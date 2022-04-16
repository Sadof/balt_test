<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("role");
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            "name" => "Admin",
            "email" => "admin@admin.ru",
            "password" => Hash::make("Admin"),
            "role" => "admin",
        ]);
        User::create([
            "name" => "User",
            "email" => "user@user.ru",
            "password" => Hash::make("User"),
            "role" => "user",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
