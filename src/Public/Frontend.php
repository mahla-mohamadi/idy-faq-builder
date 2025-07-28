<?php
namespace MyPlugin\Public;

use MyPlugin\Logger;

class Frontend {
    private static $instance = null;
    private $logger;

    public static function init(Logger $logger): void {
        if (null === self::$instance) {
            self::$instance = new self($logger);
        }
        // Add frontend hooks if needed
    }

    private function __construct(Logger $logger) {
        $this->logger = $logger;
        $this->logger->log('Frontend initialized');
    }

    private function __clone() {}
}