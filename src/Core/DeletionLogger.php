<?php
namespace Core;

class DeletionLogger {
    public function log($message, $data) {
        $entry = "[DELETION] $message" . PHP_EOL .
                 json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;

        echo "DELETION LOGGED SUCCESSFULLY!" . PHP_EOL . PHP_EOL;
        file_put_contents(__DIR__ . '/../../logs/deletion.log', $entry, FILE_APPEND);
    }
}
