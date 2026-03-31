<?php
namespace Core;

class PrintLogger {
    public function log($message, $data) {
        $entry = "[PRINT] $message" . PHP_EOL .
                 json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;

        echo $entry;
        file_put_contents(__DIR__ . '/../../logs/print.log', $entry, FILE_APPEND);
    }
}

