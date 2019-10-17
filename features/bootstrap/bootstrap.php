<?php

use Symfony\Component\Dotenv\Dotenv;

// Check to ensure that .env is not used in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV variable is not defined.');
    }
    (new Dotenv())->load(__DIR__.'/../../.env.test.local');
}
