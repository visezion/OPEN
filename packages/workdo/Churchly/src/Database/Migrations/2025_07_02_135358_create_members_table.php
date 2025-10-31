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
        if (!Schema::hasTable('church_members')) {
            Schema::create('church_members', function (Blueprint $table) {
                $table->id();

                // 🔗 User relationship
                $table->unsignedBigInteger('user_id')->nullable()->index();

                // 🧑 Basic Info
                $table->string('name');
                $table->string('profile_photo')->nullable();
                $table->date('dob')->nullable();
                $table->string('gender', 20)->nullable();
                $table->string('phone', 20)->nullable()->index();
                $table->string('email')->index();
                $table->longText('address')->nullable();

                // 🆔 Membership
                $table->string('member_id')->unique();
                $table->unsignedBigInteger('branch_id')->index();
                $table->unsignedBigInteger('department_id')->nullable()->index();
                $table->unsignedBigInteger('designation_id')->nullable()->index();
                $table->unsignedBigInteger('role_id')->nullable()->index();
                $table->date('church_doj')->nullable();
                $table->string('membership_status')->default('Active');

                // 👨‍👩‍👧 Family Links
                $table->unsignedBigInteger('family_id')->nullable()->index();
                $table->unsignedBigInteger('spouse_id')->nullable()->index();

                // 🚑 Emergency Contact
                $table->string('emergency_contact')->nullable();
                $table->string('emergency_phone', 20)->nullable();

                // ⚙️ System Controls
                $table->boolean('is_active')->default(true);
                $table->unsignedBigInteger('workspace')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_members');
    }
};
