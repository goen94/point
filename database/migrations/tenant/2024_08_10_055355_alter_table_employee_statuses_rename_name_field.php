<?php

use Illuminate\Database\Migrations\Migration;

class AlterTableEmployeeStatusesRenameNameField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = ['ON GOING CONTRACT', 'END CONTRACT'];
        for ($i = 0; $i < count($status); $i++) {
            DB::connection('tenant')->table('employee_statuses')->where('id', $i + 1)->update([
                'name' => $status[$i]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $status = ['ACTIVE', 'ARCHIVE'];
        for ($i = 0; $i < count($status); $i++) {
            DB::connection('tenant')->table('employee_statuses')->where('id', $i + 1)->update([
                'name' => $status[$i]
            ]);
        }
    }
}
