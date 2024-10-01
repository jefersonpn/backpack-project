<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'type' column with ENUM values (1 = superadmin, 2 = admin, 3 = user)
            $table->enum('type', ['1', '2', '3'])->default('3')->after('email');
            // '1' = superadmin, '2' = admin, '3' = user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'type' column if the migration is rolled back
            $table->dropColumn('type');
        });
    }
}
