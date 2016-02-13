<?php

class MigrationTask extends \Phalcon\Cli\Task {

	public function dumpAction() {
		Rj\Migration::dump();
	}

	public function genAction() {
		Rj\Migration::gen();
	}

	public function runAction() {
		Rj\Migration::run();
	}

}
