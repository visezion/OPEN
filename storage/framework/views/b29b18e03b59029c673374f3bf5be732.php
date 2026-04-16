<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaratrustUpgradeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($laratrust['teams']['enabled']): ?>
        // Create table for storing teams
        Schema::create('<?php echo e($laratrust['tables']['teams']); ?>', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('<?php echo e($laratrust['tables']['role_user']); ?>', function (Blueprint $table) {
            // Drop role foreign key and primary key
            $table->dropForeign(['<?php echo e($laratrust['foreign_keys']['role']); ?>']);
            $table->dropPrimary(['<?php echo e($laratrust['foreign_keys']['user']); ?>', '<?php echo e($laratrust['foreign_keys']['role']); ?>', 'user_type']);

            // Add <?php echo e($laratrust['foreign_keys']['team']); ?> column
            $table->unsignedInteger('<?php echo e($laratrust['foreign_keys']['team']); ?>')->nullable();

            // Create foreign keys
            $table->foreign('<?php echo e($laratrust['foreign_keys']['role']); ?>')->references('id')->on('<?php echo e($laratrust['tables']['roles']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('<?php echo e($laratrust['foreign_keys']['team']); ?>')->references('id')->on('<?php echo e($laratrust['tables']['teams']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

            // Create a unique key
            $table->unique(['<?php echo e($laratrust['foreign_keys']['user']); ?>', '<?php echo e($laratrust['foreign_keys']['role']); ?>', 'user_type', '<?php echo e($laratrust['foreign_keys']['team']); ?>']);
        });

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        Schema::table('<?php echo e($laratrust['tables']['permission_user']); ?>', function (Blueprint $table) {
           // Drop permission foreign key and primary key
            $table->dropForeign(['<?php echo e($laratrust['foreign_keys']['permission']); ?>']);
            $table->dropPrimary(['<?php echo e($laratrust['foreign_keys']['permission']); ?>', '<?php echo e($laratrust['foreign_keys']['user']); ?>', 'user_type']);

            $table->foreign('<?php echo e($laratrust['foreign_keys']['permission']); ?>')->references('id')->on('<?php echo e($laratrust['tables']['permissions']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($laratrust['teams']['enabled']): ?>
            // Add <?php echo e($laratrust['foreign_keys']['team']); ?> column
            $table->unsignedInteger('<?php echo e($laratrust['foreign_keys']['team']); ?>')->nullable();

            $table->foreign('<?php echo e($laratrust['foreign_keys']['team']); ?>')->references('id')->on('<?php echo e($laratrust['tables']['teams']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['<?php echo e($laratrust['foreign_keys']['user']); ?>', '<?php echo e($laratrust['foreign_keys']['permission']); ?>', 'user_type', '<?php echo e($laratrust['foreign_keys']['team']); ?>']);
<?php else: ?>
            $table->primary(['<?php echo e($laratrust['foreign_keys']['user']); ?>', '<?php echo e($laratrust['foreign_keys']['permission']); ?>', 'user_type']);
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
<?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\upgrade-migration.blade.php ENDPATH**/ ?>