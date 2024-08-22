<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmployeesAddCallbackUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tenant')->table('employees', function (Blueprint $table) {
            //? Add column callback_url to employees table because we need to store the callback url for each employee if their contract is on due date
            $table->string('due_date_callback_url')->after('reason_ended_contract')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tenant')->table('employees', function (Blueprint $table) {
            $table->dropColumn('due_date_callback_url');
        });
    }
}
