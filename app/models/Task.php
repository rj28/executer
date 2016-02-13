<?php

class Task extends Model {

	public $task_id, $script, $title, $executed_at;

	public function getSource() {
		return 'exec_task';
	}

}
