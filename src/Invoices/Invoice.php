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

    public function getInvoiceId(): int {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): void {
        $this->invoiceId = $invoiceId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getRateCard(): int {
        return $this->rateCard;
    }

    public function setRateCard(int $rateCard): void {
        $this->rateCard = $rateCard;
    }

    public function getManifestId(): int {
        return $this->manifestId;
    }

    public function setManifestId(int $manifestId): void {
        $this->manifestId = $manifestId;
    }

    public function getIncome(): float {
        return $this->income;
    }

    public function setIncome(float $income): void {
        $this->income = $income;
    }

    public function getExpense(): float {
        return $this->expense;
    }

    public function setExpense(float $expense): void {
        $this->expense = $expense;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate): void {
        $this->endDate = $endDate;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getPaymentStatus(): string {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(string $paymentStatus): void {
        $this->paymentStatus = $paymentStatus;
    }

    public function getEmailStatus(): string {
        return $this->emailStatus;
    }

    public function setEmailStatus(string $emailStatus): void {
        $this->emailStatus = $emailStatus;
    }

    public function getInternalReference(): string {
        return $this->internalReference;
    }

    public function setInternalReference(string $internalReference): void {
        $this->internalReference = $internalReference;
    }

    public function getExternalReference(): string {
        return $this->externalReference;
    }

    public function setExternalReference(string $externalReference): void {
        $this->externalReference = $externalReference;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

