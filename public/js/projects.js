/*
 * Frontend logic for creation and managing projects.
 */
const userID = document.body.dataset.userId;
let currentEditProjectID = null;
const projectsPerPage = 10;
let currentPage = 1;
let allProjects = [];

// Helper functions for error handling
function showError(inputId, errorId, message) {
    const inputElement = $(`#${inputId}`);
    const errorElement = $(`#${errorId}`);

    inputElement.removeClass('is-valid').addClass('is-invalid');
    errorElement.removeClass('valid-feedback').addClass('invalid-feedback');
    errorElement.text(message).show();
}

function showSuccess(inputId, errorId, message) {
    const inputElement = $(`#${inputId}`);
    const errorElement = $(`#${errorId}`);

    inputElement.removeClass('is-invalid').addClass('is-valid');
    errorElement.removeClass('invalid-feedback').addClass('valid-feedback');
    errorElement.text(message).show();
}

function clearError(inputId, errorId) {
    const inputElement = $(`#${inputId}`);
    const errorElement = $(`#${errorId}`);

    inputElement.removeClass('is-invalid is-valid');
    errorElement.removeClass('invalid-feedback valid-feedback');
    errorElement.text('').hide();
}

function clearAllErrors() {
    clearError('nameChange', 'nameChangeError');
    clearError('addUser', 'addUserError');
}

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
            <button class="btn btn-sm btn-outline-success openButton">Open</button>
            <button class="btn btn-sm btn-outline-primary editButton">Edit</button>
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
            project.num_columns,
            project.num_tasks,
            project.num_members
        )
    ).join('');
}

function renderPaginationTabs(totalProjects) {
    const totalPages = Math.ceil(totalProjects / projectsPerPage);
    const tabsContainer = document.getElementById('paginationTabs');

    if (!tabsContainer) return;

    if (totalPages <= 1) {
        tabsContainer.innerHTML = `
            <li class="nav-item">
                <a class="nav-link active" href="#">Page 1</a>
            </li>
        `;
        return;
    }

    let tabsHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        const isActive = i === currentPage ? 'active' : '';
        tabsHTML += `
            <li class="nav-item">
                <a class="nav-link page-tab ${isActive}" href="#" data-page="${i}">Page ${i}</a>
            </li>
        `;
    }

    tabsContainer.innerHTML = tabsHTML;
}

function renderPaginationInfo(totalProjects) {
    const startIdx = (currentPage - 1) * projectsPerPage + 1;
    const endIdx = Math.min(currentPage * projectsPerPage, totalProjects);
    const infoElement = document.getElementById('paginationInfo');

    if (!infoElement) return;

    if (totalProjects === 0) {
        infoElement.textContent = 'No projects found';
    } else {
        infoElement.textContent = `Showing ${startIdx} to ${endIdx} of ${totalProjects} entries`;
    }
}

function displayCurrentPage() {
    const startIdx = (currentPage - 1) * projectsPerPage;
    const endIdx = startIdx + projectsPerPage;
    const projectsToShow = allProjects.slice(startIdx, endIdx);

    populateProjectsTable(projectsToShow);
    renderPaginationTabs(allProjects.length);
    renderPaginationInfo(allProjects.length);
}

async function fetchProjects() {
    try {
        const response = await fetch('/SteadyPlan/api/user-projects.php', {
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
        });

        const data = await response.json();

        if (response.ok) {
            allProjects = data.projects || [];
            displayCurrentPage();
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

// Handle page tab clicks
$(document).on('click', '.page-tab', event => {
    event.preventDefault();
    const page = parseInt($(event.currentTarget).data('page'));
    if (page !== currentPage) {
        currentPage = page;
        displayCurrentPage();
    }
});

// Handle buttons
$(document).on('click', '.openButton', event => {
    const projectID = $(event.currentTarget).closest('tr').prop('id');
    window.location.href = `/SteadyPlan/public/project-board.php?projectID=${encodeURIComponent(projectID)}`;
});

$(document).on('click', '.editButton', event => {
    currentEditProjectID = $(event.currentTarget).closest('tr').prop("id");

    const currentName = $(event.currentTarget).closest('tr').find('td:first').text();
    $('#nameChange').val(currentName);

    // Clear any previous errors
    clearAllErrors();

    $('.overlay').css('display', 'flex');
});

$(document).on('click', '.deleteButton', async event => {
    const projectID = $(event.currentTarget).closest('tr').prop("id");
    const payload = {
        project_id: projectID
    };
    try {
        let res = await serviceConnect(payload, "deleteProject");
        if (res.status !== 200) {
            alert("Failed to delete project: " + (res.error || 'Unknown error'));
            return;
        }
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
        const response = await fetch(`/SteadyPlan/api/add-project.php`, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            const err = await response.json().catch(() => ({}));
            throw new Error(err.error || `HTTP ${response.status}`);
        }

        const data = await response.json().catch(() => ({}));
        console.log("Success:", data);

        // Clear input
        $('#addProjectInput').val('');

        // Refresh projects to get the new project with correct data
        await fetchProjects();

        // Navigate to last page (where new project will be)
        const totalPages = Math.ceil(allProjects.length / projectsPerPage);
        if (totalPages > 0) {
            currentPage = totalPages;
            displayCurrentPage();
        }
    } catch (e) {
        console.error("add project failed:", e.message);
        alert("Failed to add project. Please try again.");
    }
});

$('#nameChangeBtn').on('click', async event => {
    // Clear previous errors
    clearError('nameChange', 'nameChangeError');

    if (!currentEditProjectID) {
        console.error("No project id found");
        return;
    }

    const rawValue = $('#nameChange').val()
    // validate the input to check if it's not the same as before
    let currentProject = allProjects.find(p => p.project_id === currentEditProjectID);
    if (currentProject && currentProject.project_name === rawValue.trim()) {
        showError('nameChange', 'nameChangeError', 'The new project name must be different from the current name');
        return;
    }

    const safeValue = rawValue ? rawValue.trim() : ""
    if (!safeValue) {
        showError('nameChange', 'nameChangeError', 'Please enter a valid project name');
        return;
    }

    const payload = {
        project_id: currentEditProjectID,
        new_name: safeValue
    };
    try {
        const response = await serviceConnect(payload, "changeProjectName");

        if (response.status !== 200) {
            showError('nameChange', 'nameChangeError', response.error || 'Failed to update project name');
            return;
        }

        // Update the project in the array
        const project = allProjects.find(p => p.project_id === currentEditProjectID);
        if (project) {
            project.project_name = safeValue;
        }

        setTimeout(() => {
            clearError('nameChange', 'nameChangeError');
        }, 1500);

        // Refresh display
        displayCurrentPage();

        // Show success feedback
        showSuccess('nameChange', 'nameChangeError', 'Project name updated successfully!');
    } catch (e) {
        console.error("change project name failed");
        showError('nameChange', 'nameChangeError', 'Failed to update project name. Please try again.');
    }
});

$('#addUserBtn').on('click', async event => {
    // Clear previous errors
    clearError('addUser', 'addUserError');

    if (!currentEditProjectID) return;

    const username = $('#addUser').val().trim();
    if (!username) {
        showError('addUser', 'addUserError', 'Please enter a username');
        return;
    }

    const payload = {
        project_id: currentEditProjectID,
        username: username
    };

    try {
        let res = await serviceConnect(payload, "addProjectUser");
        if (res.status === 200) {
            // Show success feedback
            showSuccess('addUser', 'addUserError', 'User added successfully!');

            // Clear the input and success message after a short delay
            setTimeout(() => {
                $('#addUser').val('');
                clearError('addUser', 'addUserError');
            }, 1500);

            fetchProjects();
        } else {
            showError('addUser', 'addUserError', res.error || 'Failed to add user');
        }
    } catch (e) {
        console.error("Failed to add project user. " + e.message);
        showError('addUser', 'addUserError', 'An error occurred. Please try again.');
    }
});

$('#closeOverlay').on('click', event => {
    $('.overlay').css('display', 'none');
    currentEditProjectID = null;
});

async function serviceConnect(payload, endpoint) {
    return fetch(`/SteadyPlan/api/${endpoint}.php`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(payload)
    }).then(async response => {
        const err = await response.json().catch(() => ({}));
        // return the returned json with the status code from the response
        err.status = response.status;
        return err;
    });
}