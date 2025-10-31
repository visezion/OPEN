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
        Schema::create('church_households', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('primary_contact_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 3)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('primary_contact_id')
                ->references('id')
                ->on('church_members')
                ->nullOnDelete();
        });

        Schema::create('church_household_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')
                ->constrained('church_households')
                ->cascadeOnDelete();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->string('relationship')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->date('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['household_id', 'member_id']);
        });

        Schema::create('church_member_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('author_id')->index();
            $table->string('title')->nullable();
            $table->text('body');
            $table->enum('visibility', ['staff', 'pastoral', 'leaders', 'private'])->default('staff');
            $table->json('tags')->nullable();
            $table->boolean('requires_attention')->default(false);
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::create('church_member_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('assigned_to')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->date('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->timestamps();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        Schema::create('church_member_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->string('channel'); // email, sms, call, visit, note, other
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable()->index();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->timestamps();

            $table->foreign('sent_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        Schema::create('church_member_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->date('received_at')->nullable();
            $table->string('method')->nullable();
            $table->string('reference')->nullable();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('recorded_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('recorded_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        Schema::create('church_smart_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('definition');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('church_smart_tag_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smart_tag_id')
                ->constrained('church_smart_tags')
                ->cascadeOnDelete();
            $table->foreignId('member_id')
                ->constrained('church_members')
                ->cascadeOnDelete();
            $table->timestamp('matched_at')->nullable();
            $table->timestamps();

            $table->unique(['smart_tag_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_smart_tag_members');
        Schema::dropIfExists('church_smart_tags');
        Schema::dropIfExists('church_member_contributions');
        Schema::dropIfExists('church_member_communications');
        Schema::dropIfExists('church_member_followups');
        Schema::dropIfExists('church_member_notes');
        Schema::dropIfExists('church_household_members');
        Schema::dropIfExists('church_households');
    }
};
