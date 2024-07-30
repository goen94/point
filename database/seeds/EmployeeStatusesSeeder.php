<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['ACTIVE', 'ARCHIVE', 'ON GOING CONTRACT', 'END CONTRACT'];
        for ($i = 0; $i < count($status); $i++) {
            $check_status = DB::connection('tenant')->table('employee_statuses')->where('name', $status[$i])->first();

            if (!$check_status) {
                DB::connection('tenant')->table('employee_statuses')->insert([
                    'id' => $i + 1,
                    'name' => $status[$i],
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
