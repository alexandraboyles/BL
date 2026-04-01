<?php
namespace Invoices;

use Core\BaseModel;
use Core\Validator;

class Invoice extends BaseModel {
    public int $invoiceId;
    public $customerId;
    public int $rateCard;
    public int $manifestId;
    public float $income;
    public float $expense;
    public $startDate;
    public $endDate;
    public string $status;
    public string $paymentStatus;
    public string $emailStatus;
    public string $internalReference;
    public string $externalReference;

    public function __construct($invoiceId, $customerId, $rateCard, $manifestId, $income, $expense, $startDate, $endDate, $status, $paymentStatus, $emailStatus, $internalReference, $externalReference) {
        parent::__construct();

        [$this->startDate, $this->endDate] = Validator::validDateRange($startDate, $endDate);
        $this->income  = Validator::nonNegativeNumber($income, "Income");
        $this->expense = Validator::nonNegativeNumber($expense, "Expense");

        $this->invoiceId = $invoiceId;
        $this->customerId = $customerId;
        $this->rateCard = $rateCard;
        $this->manifestId = $manifestId;
        $this->status = $status;
        $this->paymentStatus = $paymentStatus;
        $this->emailStatus = $emailStatus;
        $this->internalReference = $internalReference;
        $this->externalReference = $externalReference;
    }
}
