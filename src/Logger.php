<?php

declare(strict_types=1);

namespace vBulletin;

class Logger
{
    private string $logFile;

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    public function log(string $message): void
    {
        $file = fopen($this->logFile, 'a+');
        fwrite($file, $message . "\n");
        fclose($file);
    }
}