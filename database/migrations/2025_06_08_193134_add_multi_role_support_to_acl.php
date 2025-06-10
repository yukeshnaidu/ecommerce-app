<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultiRoleSupportToAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     // Remove the single role_id column if it exists
        //     $table->dropColumn('role_id');
        // });

        // Create pivot table for user roles
        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
                
            $table->primary(['user_id', 'role_id']);
        });

        // Create table for user-specific permissions
        Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');
                
            $table->primary(['user_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the user_has_permissions table
        Schema::dropIfExists('user_has_permissions');

        // Drop the user_has_roles table
        Schema::dropIfExists('user_has_roles');

        // Add back the role_id column to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('id');

            // Optional: Add back foreign key if it existed before
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('set null');
        });
    }

}
