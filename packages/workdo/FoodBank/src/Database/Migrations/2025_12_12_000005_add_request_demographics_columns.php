<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('requester_name');
            $table->enum('marital_status', ['single', 'married', 'other'])->default('single')->after('occupation');
            $table->integer('family_size')->nullable()->after('marital_status');
            $table->integer('children_count')->nullable()->after('family_size');
            $table->text('dietary_requirements')->nullable()->after('needs_description');
        });
    }

    public function down(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->dropColumn([
                'occupation',
                'marital_status',
                'family_size',
                'children_count',
                'dietary_requirements',
            ]);
        });
    }
};
