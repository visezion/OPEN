<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('add_ons')) {
            return;
        }

        $seedPackages = false;

        if (!Schema::hasColumn('add_ons', 'image')) {
            Schema::table('add_ons', function (Blueprint $table) {
                $table->string('image')->nullable()->after('yearly_price');
            });

            $seedPackages = true;
        }

        if (!Schema::hasColumn('add_ons', 'is_enable')) {
            $afterColumn = Schema::hasColumn('add_ons', 'image') ? 'image' : 'yearly_price';

            Schema::table('add_ons', function (Blueprint $table) use ($afterColumn) {
                $table->boolean('is_enable')->default(0)->after($afterColumn);
            });

            $seedPackages = true;
        }

        if (!Schema::hasColumn('add_ons', 'package_name')) {
            $afterColumn = Schema::hasColumn('add_ons', 'is_enable') ? 'is_enable' : 'yearly_price';

            Schema::table('add_ons', function (Blueprint $table) use ($afterColumn) {
                $table->string('package_name')->nullable()->after($afterColumn);
            });

            $seedPackages = true;
        }

        if ($seedPackages && Schema::hasColumn('add_ons', 'package_name')) {
            Artisan::call('db:seed', [
                '--class' => 'PackagesName',
                '--force' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('add_ons', function (Blueprint $table) {
            if (Schema::hasColumn('add_ons', 'package_name')) {
                $table->dropColumn('package_name');
            }

            if (Schema::hasColumn('add_ons', 'is_enable')) {
                $table->dropColumn('is_enable');
            }

            if (Schema::hasColumn('add_ons', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
