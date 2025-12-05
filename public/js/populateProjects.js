const userID = document.body.dataset.userId;

function tableRowOutline(project_id, projectName, ownerName, numUsers, numCols, numTasks) {
    return `<tr id="${project_id}">
        <td>${projectName}</td>
        <td>
            <div class="d-flex align-items-center justify-content-center">
                <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">${ownerName ? ownerName[0] : '?'}</div>
                ${ownerName || 'Unknown'}
            </div>
        </td>
        <td>${numUsers}</td>
        <td>${numCols}</td>
        <td>${numTasks}</td>
        <td>
            <button class="btn btn-sm btn-outline-primary openButton">Open</button>
            <button class="btn btn-sm btn-outline-success editButton">Edit</button>
            <button class="btn btn-sm btn-outline-danger deleteButton">Delete</button>
        </td>
    </tr>`;
}

function populateProjectsTable(projects) {
    const tbody = document.getElementById('projectTableBody');
    tbody.innerHTML = ''; // Clear existing rows
    tbody.innerHTML += projects.map(project =>
        tableRowOutline(
            project.project_id,
            project.project_name,
            project.owner_username,
            project.num_users,
            project.num_cols,
            project.num_tasks
        )
    ).join('');
}

async function fetchProjects() {
    try {
        const response = await fetch('/SteadyPlan/api/user-projects.php', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });

        const data = await response.json();

        if (response.ok) {
            console.log(data.projects);
            populateProjectsTable(data.projects);
            console.log('Projects fetched successfully');
        } else {
            console.error(data.error || 'Failed to fetch projects');
        }
    } catch (error) {
        console.error('An error occurred while fetching projects:', error);
    }
}

$(document).ready(() => {
    fetchProjects();
});

// Handle buttons
$(document).on('click', '.openButton', event => {
    const projectName = $(event.currentTarget).closest('tr').find('td:first').text();
    window.location.href = `../project-board.php?project=${encodeURIComponent(projectName)}`;
});

$(document).on('click', '.editButton', event => {
    $('.overlay').css('display', 'flex');
});

$(document).on('click', '.deleteButton', event => {
    const projectID = $(event.currentTarget).closest('tr').prop("id");
    const payload = {
        project_id: projectID,
        user_id: userID
    };
    serviceConnect(payload, "deleteProject");
});

$(document).on('click', '#addProject', event => {
    const projectName = $('#addProjectInput').val().trim();
    if (!projectName) return alert("Please enter a project name");
    const payload = {
        project_owner: userID,
        project_name: projectName
    };
    serviceConnect(payload, "add-project");
    fetchProjects();
});

$('#nameChange').on('click', event => {
    let projectID = $(event.currentTarget).closest('tr').prop("id");
    const payload = {
        project_id: projectID,
        new_name: $('#projectNameInput').val()
    };
    serviceConnect(payload, "changeProjectName");
    fetchProjects();
});

$('#addUser').on('click', event => {
    let projectID = $(event.currentTarget).closest('tr').prop("id");
    const payload = {
        project_id: projectID,
        user_id: $('#userIDInput').val()
    };
    serviceConnect(payload, "addProjectUser");
    fetchProjects();
});

$('#closeOverlay').on('click', event => {
    $('.overlay').css('display', 'none');
});

function serviceConnect(payload, endpoint) {
    fetch(`/api/${endpoint}.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
        .then(async (res) => {
            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                throw new Error(err.error || `HTTP ${res.status}`);
            }
            return res.json().catch(() => ({}));
        })
        .then((data) => {
            console.log("Success:", data);
        })
        .catch((err) => {
            console.error("Request failed:", err.message);
        });
}