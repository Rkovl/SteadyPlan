<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper m-5">
        <div class="table-container">
            <div class="header-controls">
                <div>
                    <h4 class="mb-0">All Projects</h4>
                    <p class="text-muted small mb-0">Manage and track your projects</p>
                </div>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm search-box" placeholder="Search projects...">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Project
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="form-check-input"></th>
                            <th>Name</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Value</th>
                            <th>Assigned To</th>
                            <th>Stage</th>
                            <th>Priority</th>
                            <th>Next Call</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>TR Capital</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">DL</div>
                                    Devon Lane
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>-</td>
                            <td>
                                <div class="user-avatar" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">UN</div>
                            </td>
                            <td><span class="badge badge-prospects">Prospects</span></td>
                            <td><i class="fas fa-circle priority-low"></i></td>
                            <td>-</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>Gillette</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">RR</div>
                                    Ronald Richards
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>$120,45,121,565</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">CF</div>
                                    Cody Fisher
                                </div>
                            </td>
                            <td><span class="badge badge-lead">Lead</span></td>
                            <td><i class="fas fa-circle priority-urgent"></i></td>
                            <td>07/12/2022</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>Pizza Hut</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">RF</div>
                                    Robert Fox
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>$120,45,121,565</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">JC</div>
                                    Jane Cooper
                                </div>
                            </td>
                            <td><span class="badge badge-prospects">Prospects</span></td>
                            <td><i class="fas fa-circle priority-high"></i></td>
                            <td>07/12/2022</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>Pulvinar Vitae</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">JJ</div>
                                    Jacob Jones
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>$120,45,121,565</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #ff6e7f 0%, #bfe9ff 100%);">RE</div>
                                    Ralph Edward
                                </div>
                            </td>
                            <td><span class="badge badge-poc">POC</span></td>
                            <td><i class="fas fa-circle priority-low"></i></td>
                            <td>07/12/2022</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>Starbucks</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);">GH</div>
                                    Guy Hawkins
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>$120,45,121,565</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">RR</div>
                                    Ronald Richar
                                </div>
                            </td>
                            <td><span class="badge badge-closed">Closed</span></td>
                            <td><i class="fas fa-circle priority-normal"></i></td>
                            <td>07/12/2022</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td><strong>Louis Vuitton</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #fdcbf1 0%, #e6dee9 100%);">FM</div>
                                    Floyd Miles
                                </div>
                            </td>
                            <td>07/12/2022</td>
                            <td>$120,45,121,565</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">DS</div>
                                    Darrell Stewar
                                </div>
                            </td>
                            <td><span class="badge badge-pricing">Pricing</span></td>
                            <td><i class="fas fa-circle priority-high"></i></td>
                            <td>07/12/2022</td>
                            <td>
                                <button class="btn btn-outline-primary btn-action"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger btn-action"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing 1 to 6 of 6 entries
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>