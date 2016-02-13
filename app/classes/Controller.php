<?php

class Controller extends Rj\Controller {

	public function initialize() {
		$file = DOCROOT . '/../app/cache/ping';
		if (file_exists($file)) {
			$time = (int) file_get_contents($file);
		} else {
			$time = 0;
		}

		$this->view->setVar('ping_time', time() - $time);
	}

}
