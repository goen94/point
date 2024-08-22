<?php

namespace App\Model\HumanResource\Employee;

use App\Model\MasterModel;

class EmployeeReviewer extends MasterModel
{
    protected $connection = 'tenant';

    public static $alias = 'employee_reviewer';

    protected $table = 'employee_reviewer';
}
