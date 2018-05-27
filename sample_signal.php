#!/usr/bin/env php
<?php 

declare(ticks = 1);

require_once __DIR__ . '/vendor/autoload.php'; 

use Symfony\Component\Console\Application;
use SignalDemo\SignalCommand;

// create new symfony cli application
$app = new Application("Sample Signals", "0.1");

// append commands
$app->add(new SignalCommand());

// start application
$app->run();
