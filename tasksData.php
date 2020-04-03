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
		    'isDone' => $isDone
		);

		file_put_contents("data/tasks.json", json_encode($toUpdate));

		return $toUpdate["tasks"];
	}

	public function editTasks($username, $email, $text, $isDone) {
		$toUpdate = $this->tasks;

		//$toUpdate[0]['username'] = $username;
		foreach ($toUpdate["tasks"] as $key => $entry) {
			if ($entry['username'] == $username && $entry['email'] == $email) {
				$toUpdate["tasks"][$key]['text'] = $text;
				$toUpdate["tasks"][$key]['isDone'] = json_encode($isDone);
			}
		}

		file_put_contents("data/tasks.json", json_encode($toUpdate));
	}

}

?>