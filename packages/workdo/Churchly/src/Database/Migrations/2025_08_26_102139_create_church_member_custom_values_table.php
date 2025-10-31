<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_member_custom_values', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('field_id')->nullable()->index(); // links to ChurchMemberField.id

            // 📝 Value
            $table->string('field_key');   // e.g. "baptism_date"
            $table->text('field_value')->nullable(); // value (string, JSON for checkbox)
            
            $table->unsignedBigInteger('workspace')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign keys (optional, can be uncommented if you want constraints)
            // $table->foreign('member_id')->references('id')->on('church_members')->onDelete('cascade');
            // $table->foreign('field_id')->references('id')->on('church_member_custom_fields')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_member_custom_values');
    }
};
