<?php
require_once("./tasksData.php");
require_once("./tasksViewer.php");

/**
 * the controller of the structure. 
 */
class Controller
{
	private $model;
	private $tasks;
	public $sortingField;

	public function __construct() {
		$this->model = new Model();
		$this->tasks = $this->model->getTasks(); 
	}
	
	public function sortByField() {
		// simple sorting
		usort($this->tasks, function($a, $b) {
			if ($a[$this->sortingField] < $b[$this->sortingField]) {
				return -1;
			}

			if ($a[$this->sortingField] > $b[$this->sortingField]) {
				return 1;
			}

			return 0;
		});

		return $this->tasks;
	}

	public function addTask($username, $email, $text, $isDone) {
		return $this->model->setTasks($username, $email, $text, $isDone);
	}

	public function editTasks($username, $email, $text, $isDone) {
		$this->model->editTasks($username, $email, $text, $isDone);
	}

}


$controller = new Controller(); 
$tasksViewer = new View();

// sending the response for sorting requests
if($_POST['source'] == 'username') { 
	$controller->sortingField = 'username';
	print $tasksViewer->populateControl($controller->sortByField());
}
if($_POST['source'] == 'email') {
	$controller->sortingField = 'email';
	print $tasksViewer->populateControl($controller->sortByField());
}
if($_POST['source'] == 'status') {
	$controller->sortingField = 'isDone';
	print $tasksViewer->populateControl($controller->sortByField());
}

// sending the response for addTask requests
if($_POST['source'] == 'addTask') {
	print $tasksViewer->populateControl($controller->addTask(
											$_POST['username'], 
											$_POST['email'], 
											$_POST['text'], 
											false));
}


// admin edits requests
if($_POST['source'] == 'edit') {
	$controller->editTasks($_POST['username'], $_POST['email'], $_POST['text'], $_POST['isDone']);
}


//var_dump($_POST);
?>