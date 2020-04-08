<?php
require_once("./tasksData.php");

ob_start();
session_start();
/**
 * the view of the structure. 
 */
class View
{
	private $model;
	private $tasks;

	public function __construct() {
		$this->model = new Model();
		$this->tasks = $this->model->getTasks(); 
	}

	public function populateControl($tasks) {
		$c = 0;
		foreach ($tasks as $task=>$value)
		{
			$c++; // setting visible the first three items
			?>
			<li class="page-item task-item <?php if ($c <= 3) echo "curr" ?>">
				<div class="list-group-item card-title"> <?php echo $value["username"]; ?> </div>
				<div class="list-group-item"> <?php echo $value["email"]; ?> </div>
				<?php if (!isset($_SESSION['username']) && $_SESSION['username'] != 'admin') { ?>
				<div class="list-group-item"> <?php echo $value["text"]; ?> </div>
				<div class="list-group-item"> <?php if($value["isDone"]) echo " выполнено"; ?> </div>
				<?php } else { ?>
				<div class="list-group-item list-group-item-action"><input type="text" class="card-text text-ch" onkeyup="updateTask(this)" value="<?php echo $value["text"]; ?>" /></div>
				<div class="list-group-item list-group-item-action"><input type="checkbox" class="isDone-ch" onchange="updateTask(this)" <?php if($value["isDone"]) { echo "checked"; ?> /><?php echo " выполнено"; } ?></div>
				<?php } ?>
				<div class="list-group-item list-group-item-action a-edited">
					<?php if($value["isTextChanged"]) echo " отредактировано администратором"; ?>
				</div>
			</li>
			<?php
		}
	}

	public function calcPages($tasks)
	{
		$length = ceil(count($tasks) / 3);
		for ($i=1; $i <= $length; $i++) { ?>
			<li class="page-item"><a class="page-link page-num" href="#"><?php echo $i; ?></a></li> <?php
		}
	}
	
	public function makeControl()
	{
	?>
		<div>
			<ul class="pagination justify-content-center tasks card-body">
				<?php $this->populateControl($this->tasks); ?>
			</ul>
			<div>
				<ul class="pagination justify-content-center tasksPages">
					<?php $this->calcPages($this->tasks); ?>
				</ul>
			</div>
		</div>
	<?php
	}
}
?>