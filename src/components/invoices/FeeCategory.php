<?php
namespace Invoices;

use Core\BaseModel;

class FeeCategory extends BaseModel {
    private string $appliesTo;
    private string $account;
    private string $name;
    private bool $counts_toward_minimum_charges;
    private bool $is_name_editable;

    public function __construct($appliesTo, $account, $name, $counts_toward_minimum_charges, $is_name_editable) {
        parent::__construct();
        $this->appliesTo = $appliesTo;
        $this->account = $account;
        $this->name = $name;
        $this->counts_toward_minimum_charges = $counts_toward_minimum_charges;
        $this->is_name_editable = $is_name_editable;
    }

    public function getAppliesTo(): string {
        return $this->appliesTo;
    }

    public function setAppliesTo(string $appliesTo): void {
        $this->appliesTo = $appliesTo;
    }

    public function getAccount(): string {
        return $this->account;
    }

    public function setAccount(string $account): void {
        $this->account = $account;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCountsTowardMinimumCharges(): bool {
        return $this->counts_toward_minimum_charges;
    }

    public function setCounts_toward_minimum_charges(bool $counts_toward_minimum_charges): void {
        $this->counts_toward_minimum_charges = $counts_toward_minimum_charges;
    }

    public function getIsNameEditable(): bool {
        return $this->is_name_editable;
    }

    public function setIs_name_editable(bool $is_name_editable): void {
        $this->is_name_editable = $is_name_editable;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

