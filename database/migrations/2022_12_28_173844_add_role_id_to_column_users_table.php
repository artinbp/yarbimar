<?php

use App\Enums\UserRoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->nullable()->default(null);

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        DB::transaction(function () {
            $user = User::create([
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'password' => bcrypt('admin'),
            ]);

            $customerRole = Role::where('name', UserRoleEnum::SUPER_ADMIN)->first();
            $customerRole->users()->save($user);
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
            $table->dropColumn('role_id');
        });
    }
};
