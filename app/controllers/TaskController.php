<?php

class TaskController extends Controller {

	public function runAction() {
		Assert::found($id = (int) $this->dispatcher->getParam('0', 'uint'));
		Assert::found($job = Job::findFirst($id), "Job not found");

		$this->view->setVar('job', $job);

		if ($this->request->isAjax()) {
			if ($job->executed_at) {
				return $this->response->setJsonContent([
					'completed' => true,
					'response'  => $job->response,
				]);

			} else {
				return $this->response->setJsonContent([ 'completed' => false ]);
			}
		}
	}

	public function executeAction() {
		Assert::found($id = (int) $this->dispatcher->getParam('0', 'uint'));
		Assert::found($task = Task::findFirst($id), "Task not found");

		$job = Job::findFirst([
			'task_id = ?0 and executed_at is null',
			'bind' => [ $task->task_id ],
		]);

		if ( ! $job) {
			$job = new Job();
			$job->save([ 'task_id' => $task->task_id ]);
			Assert::noMessages($job);
		}

		return $this->response->redirect('/task/run/' . $job->job_id, true);
	}

//	public function deleteAction() {
//		Assert::found($id = (int) $this->dispatcher->getParam('0', 'uint'));
//		Assert::found($task = Task::findFirst($id), "Task not found");
//		$this->view->noRender();
//		$task->delete();
//		return $this->response->redirect('/', true);
//	}
//
//	public function editAction() {
//		Assert::found($id = (int) $this->dispatcher->getParam('0', 'uint'));
//		Assert::found($task = Task::findFirst($id), "Task not found");
//
//		$this->dispatcher->setParam('task', $task);
//		$this->view->pick('task/add');
//		return $this->addAction();
//	}
//
//	public function addAction() {
//		if ($task = $this->dispatcher->getParam('task')) {
//			$this->view->setVar('userData', $task->toArray());
//		} else {
//			$task = new Task;
//		}
//
//		if ($this->request->isPost()) {
//			$validation = new Validation();
//			$validation->add('title', Validation::presenceOf());
//			$validation->add('title', Validation::callback(function (Validation $validation, $attr) use ($task) {
//				$exists = Task::findFirst([
//					'title = ?0 and task_id != ?1',
//					'bind' => [ $validation->getValue($attr), $task->task_id ],
//				]);
//				if ($exists) $validation->appendMessage(new Phalcon\Validation\Message('Title already exists', $attr));
//			}));
//			$validation->add('script', Validation::presenceOf());
//
//			return $this->_save(
//				$validation,
//				function (Validation $validation) use ($task) {
//					$task->save([
//						'title'  => $validation->getValue('title'),
//						'script' => $validation->getValue('script'),
//					]);
//					Assert::noMessages($task);
//				},
//				function() {
//					return $this->response->redirect('/', true);
//				}
//			);
//		}
//	}

}
