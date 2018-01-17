<?php

namespace App\Traits;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

trait LoggerTrait
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    protected function hasLogger(): bool
    {
        return !empty($this->logger);
    }

    protected function log(string $level, string $message, array $context = array())
    {
        if($this->hasLogger()) {
            $message = '[' . get_class($this) . '] ' . $message;

            $this->getLogger()->log($level, $message, $context);
        }
    }

    protected function logEmergency(string $message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    protected function logAlert(string $message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    protected function logCritical(string $message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    protected function logError(string $message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    protected function logWarning(string $message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    protected function logNotice(string $message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    protected function logInfo(string $message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    protected function logDebug(string $message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}