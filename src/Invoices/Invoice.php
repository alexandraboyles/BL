<?php
namespace Invoices;

use Core\BaseModel;
use Core\Validator;

class Invoice extends BaseModel {
    private int $invoiceId;
    private $customerId;
    private int $rateCard;
    private int $manifestId;
    private float $income;
    private float $expense;
    private $startDate;
    private $endDate;
    private string $status;
    private string $paymentStatus;
    private string $emailStatus;
    private string $internalReference;
    private string $externalReference;

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
