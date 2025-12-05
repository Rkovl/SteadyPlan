const userID = document.body.dataset.userId;
let currentEditProjectID = null;

function tableRowOutline(project_id, project_name, owner, numCols, numTasks, numUsers) {
    return `<tr id="${project_id}">
        <td>${project_name}</td>
        <td>
            <div class="d-flex align-items-center justify-content-center">
                <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">${owner ? owner[0] : '?'}</div>
                ${owner || 'Unknown'}
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
            project.owner,
            project.numcols,
            project.numtasks,
            project.numusers
        )
    ).join('');
}
function testProjects(data) {
    data.projects.forEach((item) => {
        console.log(item);
    });
}

async function fetchProjects() {
    try {
        const response = await fetch('/SteadyPlan/api/user-projects.php', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });

        const data = await response.json();

        if (response.ok) {
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
    window.location.href = `./project-board.php?project=${encodeURIComponent(projectName)}`;
});

$(document).on('click', '.editButton', event => {
    currentEditProjectID = $(event.currentTarget).closest('tr').prop("id");

    const currentName = $(event.currentTarget).closest('tr').find('td:first').text();
    $('#nameChange').val(currentName);

    $('.overlay').css('display', 'flex');
});

$(document).on('click', '.deleteButton', async event => {
    const projectID = $(event.currentTarget).closest('tr').prop("id");
    const payload = {
        project_id: projectID
    };
    try {
        await serviceConnect(payload, "deleteProject");
        fetchProjects();
    } catch (e) {
        console.error("error deleting project")
    }
});

$(document).on('click', '#addProject', async event => {
    const projectName = $('#addProjectInput').val().trim();
    if (!projectName) return alert("Please enter a project name");
    const payload = {
        project_owner: userID,
        project_name: projectName
    };
    try {
        await serviceConnect(payload, "add-project");
        fetchProjects();
    } catch (e) {
        console.error("add project failed")
    }
});

$('#nameChangeBtn').on('click', async event => {
    if(!currentEditProjectID) {
        console.error("No project id found");
        return;
    }

    const rawValue = $('#nameChange').val()
    const safeValue = rawValue ? rawValue.trim() : ""
    if(!safeValue) {
        alert("fuck you")
        return;
    }

    const payload = {
        project_id: currentEditProjectID,
        new_name: safeValue
    };
    try {
        await serviceConnect(payload, "changeProjectName");

        fetchProjects();
    } catch (e) {
        console.error("change project name failed")
    }
});

$('#addUserBtn').on('click', async event => {
    if(!currentEditProjectID) return;

    const payload = {
        project_id: currentEditProjectID,
        user_id: $('#addUser').val()
    };

    try {
        await serviceConnect(payload, "addProjectUser");

        fetchProjects();
    } catch (e) {
        console.error("failed to add project user")
    }
});

$('#closeOverlay').on('click', event => {
    $('.overlay').css('display', 'none');
});

async function serviceConnect(payload, endpoint) {
    return fetch(`/api/${endpoint}.php`, {
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
            throw err;
        });
}