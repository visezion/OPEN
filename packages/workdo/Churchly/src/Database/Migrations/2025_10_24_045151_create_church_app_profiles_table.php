<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('church_app_profiles', function (Blueprint $table) {
            $table->id();

            // Tenant / Workspace
            $table->unsignedBigInteger('workspace_id')->unique();

            // App Identity
            $table->string('app_name', 191);
            $table->string('slug', 100)->unique()->comment('used for API and subdomain'); // 🆕
            $table->string('short_description', 255)->nullable(); // 🆕
            $table->text('about_text')->nullable(); // 🆕 about screen text

            // Branding & Theming
            $table->string('primary_color', 20)->default('#4A6CF7');
            $table->string('accent_color', 20)->default('#F9B200');
            $table->string('background_color', 20)->default('#FFFFFF'); // 🆕
            $table->string('text_color', 20)->default('#000000'); // 🆕
            $table->enum('theme_mode', ['light','dark','system'])->default('system');
            $table->string('font_family', 100)->default('Poppins'); // 🆕

            // Assets
            $table->string('logo_path')->nullable();
            $table->string('splash_path')->nullable();
            $table->string('icon_path')->nullable();
            $table->string('favicon_path')->nullable(); // 🆕 for website branding

            // Web & Social Links
            $table->string('website_url')->nullable(); // 🆕
            $table->string('facebook_url')->nullable(); // 🆕
            $table->string('youtube_url')->nullable(); // 🆕
            $table->string('instagram_url')->nullable(); // 🆕
            $table->string('giving_url')->nullable(); // 🆕 donations link

            // Build & Publish Info
            $table->string('bundle_id_android', 191)->nullable();
            $table->string('bundle_id_ios', 191)->nullable();
            $table->string('version', 20)->default('1.0.0'); // 🆕
            $table->enum('status', ['draft','ready','disabled'])->default('draft');
            $table->boolean('is_published')->default(false);
            $table->timestamp('last_published_at')->nullable(); // 🆕

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Relations
            $table->foreign('workspace_id')
                ->references('id')
                ->on('work_spaces')
                ->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('church_app_profiles');
    }
};
