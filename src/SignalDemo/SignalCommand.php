<?php

namespace SignalDemo;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Amp\Loop;
use Amp\Parallel\Worker\DefaultPool;

use SignalDemo\SignalTask;

class SignalCommand extends Command {

    protected function configure(){
        $this->setName("Sample:Signal")
                ->setDescription("Just an example to work with signals on console.");
    }

    protected function execute(InputInterface $input, OutputInterface $output){

      try {

        // define worker pool with 3 parallel processes
        $pool = new DefaultPool(3);

        // loop through files
        for ($signal_tasks_counter = 1; $signal_tasks_counter <= 10; $signal_tasks_counter++) {
          // create the task and push to pool
          $task = new SignalTask($signal_tasks_counter);
          $pool->enqueue($task);
        }

        // event loop for parallel tasks
        Loop::run(function () use (&$pool) {
          
          foreach (array(SIGINT, SIGTERM, SIGHUP) as $signal) {
            Loop::unreference(
              Loop::onSignal($signal,
                function () use ($signal, &$pool) {
                  echo "\nCaught SIGNAL [" . $signal . "]! Gracefully shutdown after running jobs...\n";
                  return $pool->shutdown();
                }
              )
            );
          }

        });

      }
      finally {

        echo "\nFINNALY statement was reached to cleanup your job\n";

      }

    }

}
