<?php
namespace Core;

abstract class Logger {
    abstract public function log($message, $data = []);
}
