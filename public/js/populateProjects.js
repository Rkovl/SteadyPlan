function tableRowOutline(projectName, ownerName, numUsers, numCols, numTasks) {
    return`<tr>
            <td>${projectName}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">${ownerName[0]}</div>
                    ${ownerName}
                </div>
            </td>
            <td>${numUsers}</td>
            <td>${numCols}</td>
            <td>${numTasks}</td>
            <td>
                <button class="btn btn-sm btn-outline-primary">Open</button>
                <button class="btn btn-sm btn-outline-success editButton">Edit</button>
                <button class="btn btn-sm btn-outline-danger deleteButton">Delete</button>
            </td>
        </tr>`
}

function populateProjectsTable(projects) {
    document.getElementById('projectTableBody').innerHTML += projects.map(project =>
        tableRowOutline(
            project.NAME,
            project.OWNER,
            project.NUMUSERS,
            project.NUMCOLS,
            project.NUMTASKS
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
            console.log (data.projects);
            populateProjectsTable(data.projects);
            console.log ('Projects fetched successfully');
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

$(document).on('click', '.openButton', event => {
    let projectName = $(event.currentTarget).closest('tr').find('td:first').text();
    window.location.href = `../project-board.php`;
});

$(document).on('click', '.editButton', event => {
});

$(document).on('click', '.deleteButton', event => {
});

$(document).on('click', '#addProject', event => {
    
});

