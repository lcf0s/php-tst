const pageItemsNum = 3; // items allowed to be displayed per page
let tasks = null;
let formData = null;
let getUsername = '';
let getEmail = '';
let elType = null;
let getText = null;
let getCheckbox = null;
let getAdminEdited = null;


document.addEventListener("DOMContentLoaded", function() {
	// sort buttons
	const username = document.getElementsByClassName("sort-username")[0];
	const email = document.getElementsByClassName("sort-email")[0];
	const status = document.getElementsByClassName("sort-status")[0];

	const addTask = document.getElementsByClassName("addTask")[0];
	const newUsername = document.getElementsByClassName("newTask__username")[0];
	const newEmail = document.getElementsByClassName("newTask__email")[0];
	const newText = document.getElementsByClassName("newTask__text")[0];
	formData = new FormData();
	formData.append("source", null);
	formData.append("username", null);
	formData.append("email", null);
	formData.append("text", null);
	formData.append("isDone", null);
	
	tasks = document.getElementsByClassName("tasks")[0].children;

	// page-number buttons
	const tasksPages = document.getElementsByClassName("tasksPages")[0];
	let pageNums = null,
		taskIndex = 0,
		pages = '', 
		length = 0;


	addPagesClickEvent();

	// sorting buttons events and add new task - button event
	[username, email, status, addTask].forEach(btn => {
		btn.addEventListener("click", () => {
				formData.set("source", btn.value);
				formData.set(newUsername.name, newUsername.value);
				formData.set(newEmail.name, newEmail.value);
				formData.set(newText.name, newText.value);

			fetch("tasks.php", { method: "POST", body: formData, 
								 mode: "same-origin", credentials: "same-origin" })
				.then(res => res.text()).then(data => {
					// update the pages count on new task creation
					if (btn.value === 'addTask') {
						if (!data.startsWith('Wrong')) {
							document.getElementsByClassName("tasks")[0].innerHTML = data;

							length = Math.ceil(document.getElementsByClassName("tasks")[0].children.length / 3);
							pages = '';

							for (let i=1; i <= length; i++) 
								pages += `<li class="page-item"><a class="page-link page-num" href="#">${i}</a></li>`
							
							tasksPages.innerHTML = pages;
							addPagesClickEvent();

							const done = document.createElement('div');
							done.innerText = 'Добавлено. ';
							addTask.after(done);
							document.getElementsByClassName("wrongData")[0].innerText = '';
						} else {
							document.getElementsByClassName("wrongData")[0].innerText = data;
						}
					} else 
						document.getElementsByClassName("tasks")[0].innerHTML = data;
			}).catch(err => {
				console.error("unable to fetch data: " + err)
			});
		});
	});

});

function addPagesClickEvent(pageNums) {
	document.querySelectorAll(".page-num").forEach( el => {
		el.addEventListener("click", () => {

			const currentShown = document.querySelectorAll(".curr").forEach(li => {
				li.classList.toggle("curr");
			});

			taskIndex = pageItemsNum * el.innerHTML;

			for (let i = taskIndex - 1; i >= taskIndex - pageItemsNum; i--) {
				if (tasks[i]) 
					tasks[i].classList.toggle("curr");
			}

		});
	});
}

function updateTask(el) {
	getUsername = el.closest("li").querySelector("div:nth-child(1)").innerText;
	getEmail = el.closest("li").querySelector("div:nth-child(2)").innerText;
	getText = el.closest("li").querySelector("div:nth-child(3) > input").value;
	getCheckbox = el.closest("li").querySelector("div:nth-child(4) > input").checked;
	getAdminEdited = el.closest("li").querySelector("div:nth-child(5)");
	
	formData.set("source", "edit");
	formData.set("username", getUsername);
	formData.set("email", getEmail);
	formData.set("text", elType === 'text' ? el.value : getText);
	formData.set("isDone", elType === 'checkbox' ? el.checked : getCheckbox);

	fetch("tasks.php", { method: "POST", body: formData, 
						 mode: "same-origin", credentials: "same-origin" })
	.then(res => res.text()).then(data => {
		if (data) 
			getAdminEdited.innerHTML = "отредактировано администратором";
	})
	.catch(err => {
		console.error("unable to fetch data: " + err.message)
	});
}
