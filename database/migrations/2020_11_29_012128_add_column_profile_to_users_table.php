<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProfileToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->after('password')->nullable();
            $table->string('gender')->after('date_of_birth')->nullable();
            $table->string('marital_status')->after('gender')->nullable();
            $table->string('blood_group')->after('marital_status')->nullable();
            $table->string('contact_number')->after('blood_group')->nullable();
            $table->string('profile_photo')->after('contact_number')->nullable();
            
            $table->unsignedBigInteger('id_gudang')->nullable();
            // $table->foreign('id_gudang')->references('id')->on('gudang');

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
            if (Schema::hasColumn('users', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('users', 'marital_status')) {
                $table->dropColumn('marital_status');
            }
            if (Schema::hasColumn('users', 'blood_group')) {
                $table->dropColumn('blood_group');
            }
            if (Schema::hasColumn('users', 'contact_number')) {
                $table->dropColumn('contact_number');
            }
            if (Schema::hasColumn('users', 'profile_photo')) {
                $table->dropColumn('profile_photo');
            }
        });
    }
}
