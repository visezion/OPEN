<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('birthday_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // template name
            $table->string('file_path'); // stored background file
            $table->boolean('is_active')->default(false);

            // Workspace & ownership
            $table->unsignedBigInteger('workspace')->default(0);
            $table->unsignedBigInteger('created_by')->default(0);

            // Profile photo position & size
            $table->integer('photo_x')->default(270);
            $table->integer('photo_y')->default(420);
            $table->integer('photo_width')->default(260);
            $table->integer('photo_height')->default(260);

            // Name text position & style
            $table->integer('name_x')->default(400);
            $table->integer('name_y')->default(750);
            $table->integer('name_font_size')->default(42);
            $table->string('name_font_color')->default('#000000');

            // Slogan text position & style
            $table->integer('slogan_x')->default(400);
            $table->integer('slogan_y')->default(800);
            $table->integer('slogan_font_size')->default(20);
            $table->string('slogan_font_color')->default('#444444');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('birthday_templates');
    }
};
