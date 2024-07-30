<?php

namespace App\Mail;

use App\Model\HumanResource\Employee\Employee;
use App\Model\HumanResource\Employee\EmployeeContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;


class DueDateReminderContractEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $reviewer;
    public $contract;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Employee $employee, Employee $reviewer, EmployeeContract $contract)
    {
        $this->employee = $employee;
        $this->reviewer = $reviewer;
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails/human-resource/due-date-contract-reminder')
            ->with(
                [
                    'employeeName' => $this->employee->name,
                    'reviewerName' => $this->reviewer->name,
                    'contractExpired' => convert_to_local_timezone($this->contract->contract_end)
                ]);
    }
}
