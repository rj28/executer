<?php

class Job extends Model {

	public $job_id, $task_id, $created_at, $executed_at, $response, $locked_till;

	public function getSource() {
		return 'exec_job';
	}

}
