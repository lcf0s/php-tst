<?php

/**
 *  the model of the structure. gets and sets the data.
 */
class Model
{
	private $tasks; 

	public function __construct() {
		$this->tasks = json_decode(file_get_contents("data/tasks.json"), true);
	}

	public function getTasks() {
		return $this->tasks["tasks"];
	}

	public function setTasks($username, $email, $text, $isDone) {
		$toUpdate = $this->tasks;
		$toUpdate["tasks"][] = array(
		    'username' => $username,
		    'email' => $email,
		    'text' => $text,
		    'isDone' => $isDone,
		    'isTextChanged' => 'false'
		);

		file_put_contents("data/tasks.json", json_encode($toUpdate));

		return $toUpdate["tasks"];
	}

	public function editTasks($username, $email, $text, $isDone) {
		$toUpdate = $this->tasks;
		$isTextChanged = false;

		foreach ($toUpdate["tasks"] as $key => $entry) {
			if ($entry['username'] == $username && $entry['email'] == $email) {
				if ($toUpdate["tasks"][$key]['text'] != $text) {
					$toUpdate["tasks"][$key]['text'] = $text;
					$toUpdate["tasks"][$key]['isTextChanged'] = 'true';
					$isTextChanged = true;
				} 
				$toUpdate["tasks"][$key]['isDone'] = json_encode($isDone);
			}
		}

		file_put_contents("data/tasks.json", json_encode($toUpdate));

		return $isTextChanged;
	}

}

?>