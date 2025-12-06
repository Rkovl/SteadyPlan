/*
 * Frontend logic for task creation, deletion, movement, and UI updates.
 */
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
            const data = {
                taskID: draggedTask.id,
                newColumnID: col_task_container.id
            };
            console.log('Moving task', draggedTask.id, 'to column', col_task_container.id);

            fetch('/api/move-task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(result => console.log('Task moved successfully:', result))
                .catch(error => console.error('Error moving task:', error));
        } else {
            column.appendChild(draggedTask);
        }
    }
}

function addTask(text, columnID, projectID) {
    const data = {
        text: text,
        columnID: columnID,
        projectID: projectID
    };

    fetch('/api/add-task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(result => {
        // Create the new task element
        const column = document.getElementById(columnID);
        const taskHTML = `
                <div class='task' draggable='true' id='${result.taskID}'>
                    <span>${text}</span>
                    <i class='delete-task bi bi-trash3 fs-6 ms-auto'></i>
                </div>`;
        column.insertAdjacentHTML('beforeend', taskHTML);

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
    const data = {
        taskID: taskElement.id
    };

    fetch('/api/delete-task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(result => {
        taskElement.remove();
        console.log('Task deleted successfully:', result);
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

// Add Task button event handlers
let currentColumnID = null;
const taskOverlay = document.getElementById('taskInputOverlay');
const taskInput = document.getElementById('taskNameInput');
const cancelBtn = document.getElementById('cancelTaskBtn');
const createBtn = document.getElementById('createTaskBtn');

// Function to show task input overlay
function showTaskInputOverlay(columnID) {
    currentColumnID = columnID;
    taskInput.value = '';
    taskOverlay.classList.add('active');
    taskInput.focus();
}

// Function to hide task input overlay
function hideTaskInputOverlay() {
    taskOverlay.classList.remove('active');
    currentColumnID = null;
    taskInput.value = '';
}

// Function to create task from overlay
function createTaskFromOverlay() {
    const taskText = taskInput.value.trim();
    if (taskText && currentColumnID) {
        addTask(taskText, currentColumnID, PROJECT_ID);
        hideTaskInputOverlay();
    }
}

// Add click handlers for overlay buttons
cancelBtn.addEventListener('click', hideTaskInputOverlay);
createBtn.addEventListener('click', createTaskFromOverlay);

// Allow Enter key to create task
taskInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        createTaskFromOverlay();
    }
});

// Allow Escape key to close overlay
taskInput.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        hideTaskInputOverlay();
    }
});

// Close overlay when clicking outside the modal
taskOverlay.addEventListener('click', (e) => {
    if (e.target === taskOverlay) {
        hideTaskInputOverlay();
    }
});

// Add event listeners to all "Add Task" buttons
document.querySelectorAll('.add-task-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        const column = e.target.closest('.column');
        const taskContainer = column.querySelector('.task_container');
        const columnID = taskContainer.id;
        showTaskInputOverlay(columnID);
    });
});

