<?php

class MainTask extends Phalcon\CLI\Task {

	public function executeAction() {
		$this->db->begin();
		try {
			$list = $this->db->query("
				select * from exec_job
				where (locked_till is null or locked_till < now()) and executed_at is null
				for update
			")->fetchAll();

			foreach ($list as $row) {
				$this->db->query("
					update exec_job set locked_till = now() + interval 1 minute
					where job_id = ?
				", [ $row['job_id'] ]);

				$task = Task::findFirst($row['task_id']);
				echo $row['job_id'] . ':' . $task->script . "\n";
			}

			$this->db->commit();

		} catch (Exception $e) {
			$this->db->rollback();
			throw $e;
		}
	}

	public function responseAction() {
		$id   = $this->dispatcher->getParam('id', 'uint', 0);
		$file = $this->dispatcher->getParam('file', 'string', '');

		$job = Job::findFirst([
			'executed_at is null and job_id = ?0',
			'bind' => [ $id ],
		]);

		if ($job) {
			$job->save([
				'response'    => file_get_contents($file),
				'executed_at' => date('Y-m-d H:i:s'),
			]);
			Assert::noMessages($job);

		} else {
			echo "JOB $id NOT FOUND\n";
		}
	}

	public function pingAction() {
		@ file_put_contents(DOCROOT . '/../app/cache/ping', time());
//		echo "pong\n";
	}

}
