<?php
namespace Logs;

use Core\BaseModel;

class DeletionLog extends BaseModel {
    public $model;
    public $modelId;
    public $user;
    public $dateDeleted;

    public function __construct($model, $modelId, $user, $dateDeleted) {
        parent::__construct();
        $this->model = $model;
        $this->modelId = $modelId;
        $this->user = $user;
        $this->dateDeleted = $dateDeleted;
    }
}
