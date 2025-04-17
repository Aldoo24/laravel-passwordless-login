<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("users", function (Blueprint $table) {
            if (! Schema::hasColumn("users", "email")) {
                $table->string("email")->unique();
            }

            if (! Schema::hasColumn("users", "email_verified_at")) {
                $table->timestamp("email_verified_at")->nullable();
            }

            if (Schema::hasColumn("users", "password")) {
                $table->string("password")->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            if (Schema::hasColumn("users", "email")) {
                $table->dropColumn("email");
            }

            if (Schema::hasColumn("users", "email_verified_at")) {
                $table->dropColumn("email_verified_at");
            }

            if (Schema::hasColumn("users", "password")) {
                $table->string("password")->nullable(false)->change();
            }
        });
    }
};
