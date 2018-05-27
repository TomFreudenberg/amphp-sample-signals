<?php

namespace SignalDemo;

use Amp\Parallel\Worker\Environment;
use Amp\Parallel\Worker\Task;

class SignalTask implements Task {

  private $id;

  public function __construct($id) {
    $this->id = $id;
  }

  public function run(Environment $environment) {
    echo "\nSignal " . $this->id . " Task starts ...\n";
    sleep(3);
    echo "\nSignal " . $this->id . " Task finished!\n";
  }

}

