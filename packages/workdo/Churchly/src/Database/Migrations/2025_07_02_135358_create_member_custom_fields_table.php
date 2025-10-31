<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('church_member_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable(); // ✅ field definitions not tied to one member
            $table->string('field_key');
            $table->string('field_label');
            $table->string('field_value')->nullable(); // default or options
            $table->string('field_type');              // text, textarea, date, select, checkbox
            $table->integer('order')->default(0);      // ✅ ordering
            $table->unsignedBigInteger('workspace');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index(['workspace', 'created_by']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('church_member_custom_fields');
    }
};
