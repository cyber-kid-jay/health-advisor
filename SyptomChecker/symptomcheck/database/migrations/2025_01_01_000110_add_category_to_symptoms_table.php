<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            $table->enum('category', ['respiratory', 'gastrointestinal', 'neurological', 'general'])->default('general')->after('body_part');
        });
    }

    public function down(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
