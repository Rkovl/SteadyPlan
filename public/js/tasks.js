const tasks = document.getElementsByClassName('task');
const columns = document.getElementsByClassName('column');
let draggedTask = null;
let touchStartY = 0;
let touchStartX = 0;

function addColumnDragEvents(column) {
    column.addEventListener('dragover', e => {
        e.preventDefault();
        column.classList.add('drag-over');
    });
    column.addEventListener('dragleave', e => {
        // Only remove the class if we're leaving the column entirely
        if (!column.contains(e.relatedTarget)) {
            column.classList.remove('drag-over');
        }
    });
    column.addEventListener('drop', () => {
        handleDrop(column);
    });
    column.addEventListener('dragend', () => {
        column.classList.remove('drag-over');
    });
}

function handleDrop(column) {
    column.classList.remove('drag-over');
    if (draggedTask) {
        const task_container = column.getElementsByClassName('task_container');
        if (task_container.length > 0) {
            const col_task_container = task_container[0];
            col_task_container.appendChild(draggedTask);
            // Update task's column in the database
            const formData = new FormData();
            formData.append('action', 'moveTask');
            formData.append('taskID', draggedTask.id);
            formData.append('newColumnID', col_task_container.id);
            console.log ('Moving task', draggedTask.id, 'to column', col_task_container.id);

            fetch('/controllers/column-task.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            column.appendChild(draggedTask);
        }
    }
}

function addTask(text, columnID) {
    const formData = new FormData();
    formData.append('action', 'addTask');
    formData.append('text', text);
    formData.append('columnID', columnID);

    fetch('/controllers/column-task.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // The PHP echoes the new task HTML, insert it into the appropriate column
        const column = document.getElementById(columnID);
        column.insertAdjacentHTML('beforeend', html);

        // Add drag events to the newly created task
        const newTask = column.lastElementChild;
        addDragEvents(newTask);
        addTouchEvents(newTask);

        const deleteButton = newTask.querySelector('.delete-task');
        if (deleteButton) {
            deleteButton.addEventListener('click', deleteBtnClickHandler);
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteTask(taskElement) {
    taskElement.remove();

    const formData = new FormData();
    formData.append('action', 'deleteTask');
    formData.append('taskID', taskElement.id);

    fetch('/controllers/column-task.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            taskElement.remove();
        }
    })
    .catch(error => console.error('Error:', error));
}

function addDragEvents(task) {
    task.setAttribute('draggable', 'true');
    task.addEventListener('dragstart', () => {
        draggedTask = task;
    });
    task.addEventListener('dragend', () => {
        draggedTask = null;
    });
}

function addTouchEvents(task) {
    task.addEventListener('touchstart', e => {
        draggedTask = task;
        const touch = e.touches[0];
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
        task.classList.add('dragging');
    });

    task.addEventListener('touchmove', e => {
        e.preventDefault();
        const touch = e.touches[0];
        const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);

        // Remove previous drag-over classes
        Array.from(columns).forEach(col => col.classList.remove('drag-over'));

        // Find the column below the touch point
        const columnBelow = elementBelow?.closest('.column');
        if (columnBelow) {
            columnBelow.classList.add('drag-over');
        }
    });

    task.addEventListener('touchend', e => {
        const touch = e.changedTouches[0];
        const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
        const columnBelow = elementBelow?.closest('.column');

        if (columnBelow) {
            handleDrop(columnBelow);
        }

        task.classList.remove('dragging');
        Array.from(columns).forEach(col => col.classList.remove('drag-over'));
        draggedTask = null;
    });
}

function deleteBtnClickHandler(e) {
    const taskElement = e.target.closest('.task');
    if (taskElement) {
        deleteTask(taskElement);
    }
}

Array.from(columns).forEach(column => {
    addColumnDragEvents(column);
});
Array.from(tasks).forEach(task => {
    addDragEvents(task);
    addTouchEvents(task);
    // find delete button and add event listener
    const deleteButton = task.querySelector('.delete-task');
    if (deleteButton) {
        deleteButton.addEventListener('click', deleteBtnClickHandler);
    }
});
