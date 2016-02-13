<?php

$di = new Phalcon\DI\FactoryDefault\CLI();
require_once __DIR__ . '/bootstrap.php';

restore_exception_handler();
restore_error_handler();

//Create a console application
$console = new Phalcon\CLI\Console();
$console->setDI($di);

if (1 || count($argv) == 3) {
    $task   = (string) $argv[1];
    $action = (string) $argv[2];

    try {
        try {
            $console->handle(array(
                'task'   => $task,
                'action' => $action,
				'id'     => (string) @ $argv[3],
				'file'   => (string) @ $argv[4],
            ));

        } catch (Exception $e) {
            throw $e;
        }

    } catch (Exception $e) {
        echo "Exception " . get_class($e) . " thrown with message: " . $e->getMessage() . "\n";
		echo $e->getTraceAsString() . "\n";
        exit(1);
    }

} else {
    echo "Wrong parameter count. Usage: php app/task.php task_name action_name\n";
}
