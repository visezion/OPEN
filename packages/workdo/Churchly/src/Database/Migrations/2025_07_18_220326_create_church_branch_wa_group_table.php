<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_branch_wa_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wa_group_id')->constrained('zender_wa_groups')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('church_branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_branch_wa_group');
    }
};
