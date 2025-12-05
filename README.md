# SteadyPlan
A project management tool developed by Jonathan Wirick, Ryan Kovlaske, Daniel Losso-Kiss, and Kaleb Monti.
### Description
A web app for allowing users to create projects, manage tasks, collaborate with team members, and track progress with Kanban boards.
# Project Setup
## Initial Installs
1. Go to the official EnterpriseDB website download page for PostgreSQL (https://www.enterprisedb.com/downloads/postgres-postgresql-downloads) and download the latest version of PostgreSQL, correct for your OS
2. Run the install tool
3. While waiting for the install to finish, clone this repository somewhere convenient for you
4. Proceed with all default options, and don't forget the password set for your superuser
5. Launch pgAdmin 4, which you can find via your start menu
## Postgres Configuration
6. Click the dropdown that says 'Servers'
7. When prompted, enter the superuser password you set during instillation
8. Click the dropdown that says 'Postgres 1X'
9. Right-click on Databases -> Create -> Database
10. Name the Database steady_plan_db and click save
11. Right click on the new database, and press Query Tool
## Schema Copy
12. Copy and paste everything from the schema.sql file into the Query window, and press the 'Execute Query' button (or F5)
13. Next, take the following connection string, with your password added, and paste it into the DEFAULT_CONN_STRING
    variable stored in /db/database.php
    
```postgresql://postgres:password@localhost:5432/steady_plan_db```

## Accessing the test user
