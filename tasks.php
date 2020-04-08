<?php
ob_start();
session_start();

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
		$this->sortOrder = true;
	}
	
	public function sortByField() {
		// simple sorting
		usort($this->tasks, function($a, $b) {
			if ($_SESSION['sortOrder'] ? 
				$a[$this->sortingField] < $b[$this->sortingField] :
				$a[$this->sortingField] > $b[$this->sortingField]) {
				return -1;
			}

			if ($_SESSION['sortOrder'] ? 
				$a[$this->sortingField] > $b[$this->sortingField] : 
				$a[$this->sortingField] < $b[$this->sortingField]) {
				return 1;
			}

			return 0;
		});
		
		$_SESSION['sortOrder'] = !$_SESSION['sortOrder'];

		return $this->tasks;
	}

	public function addTask($username, $email, $text, $isDone) {
		return $this->model->setTasks($username, $email, $text, $isDone);
	}

	public function editTasks($username, $email, $text, $isDone) {
		return $this->model->editTasks($username, $email, $text, $isDone);
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
	if ($_POST['username'] != '' && strlen($_POST['username']) >= 2 && strlen($_POST['username']) <= 44 &&
			$_POST['email'] != '' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
			$_POST['text'] != '' && strlen($_POST['text']) >= 3 && strlen($_POST['text']) <= 1024) {
				print $tasksViewer->populateControl($controller->addTask(
											$_POST['username'], 
											$_POST['email'], 
											$_POST['text'], 
											false,
											$_POST['isTextChanged']));
         } else {
            print 'Wrong data! Fields must not be empty. 2-44 symbols; email format; 3-1024 symbols';
         }

	
}


// admin edits requests
$msg = '';
if($_POST['source'] == 'edit') {
	if (isset($_SESSION['username'])) {
		print $controller->editTasks($_POST['username'], $_POST['email'], $_POST['text'], $_POST['isDone'], $_POST['isTextChanged']);
	}
}


//var_dump($_POST);
?>