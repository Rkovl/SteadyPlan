CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- USERS Table
CREATE TABLE IF NOT EXISTS USERS (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  username TEXT UNIQUE,
  password TEXT NOT NULL,
  email TEXT UNIQUE,
  timestamp TIMESTAMPTZ DEFAULT NOW(),
  is_admin BOOLEAN DEFAULT false,
  CONSTRAINT chk_user_or_email CHECK(email IS NOT NULL OR username IS NOT NULL)
);

-- TOKENS Table
CREATE TABLE IF NOT EXISTS TOKENS (
  token text NOT NULL,
  user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  timestamp TIMESTAMPTZ NOT NULL,
  PRIMARY KEY(token)
);

-- PROJECTS Table
CREATE TABLE IF NOT EXISTS PROJECTS (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name TEXT NOT NULL,
  owner UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

-- PROJECTS_USERS Table
CREATE TABLE IF NOT EXISTS PROJECTS_USERS (
  project_id UUID NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
  user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  PRIMARY KEY(project_id, user_id)
);

-- COLUMNS Table
CREATE TABLE IF NOT EXISTS COLUMNS (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  project_id UUID NOT NULL REFERENCES PROJECTS(id) ON DELETE CASCADE,
  name TEXT NOT NULL,
  position INTEGER NOT NULL,
  description TEXT
);

-- TASKS Table
CREATE TABLE IF NOT EXISTS TASKS (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  project_id UUID NOT NULL REFERENCES PROJECTS(id) ON DELETE CASCADE,
  column_id UUID NOT NULL REFERENCES COLUMNS(id) ON DELETE CASCADE,
  name TEXT NOT NULL,
  description TEXT,
  timestamp TIMESTAMPTZ DEFAULT NOW()
);

-- This block executes an anonymous function to
-- generate some data for the purposes of demonstration

DO $$
DECLARE
    a_user_id UUID;
    v_user_id UUID;

    v_project_id_a UUID;
    v_project_id_b UUID;

    v_col_id_a1 UUID;
    v_col_id_a2 UUID;

    v_col_id_b1 UUID;
    v_col_id_b2 UUID;

BEGIN

    INSERT INTO USERS (username, password, email, is_admin)
    VALUES ('test_user', 'hashedpassword123', 'test.user@example.com', true)
    RETURNING id INTO a_user_id;

  INSERT INTO USERS (username, password, email, is_admin)
    VALUES ('test2', 'hashedpassword1234', 'test.user@example.ca', false)
    RETURNING id INTO v_user_id;
    
    INSERT INTO PROJECTS (owner, name)
    VALUES (v_user_id, 'Website Redesign')
    RETURNING id INTO v_project_id_a;

    INSERT INTO PROJECTS (owner, name)
    VALUES (v_user_id, 'Backend Refactor')
    RETURNING id INTO v_project_id_b;
    
    INSERT INTO PROJECTS_USERS (project_id, user_id)
    VALUES (v_project_id_a, v_user_id),
           (v_project_id_b, v_user_id);
    
    INSERT INTO COLUMNS (project_id, name, position)
    VALUES (v_project_id_a, 'To Do', 1)
    RETURNING id INTO v_col_id_a1;
    
    INSERT INTO COLUMNS (project_id, name, position)
    VALUES (v_project_id_a, 'Done', 2)
    RETURNING id INTO v_col_id_a2;
    
    INSERT INTO COLUMNS (project_id, name, position)
    VALUES (v_project_id_b, 'Backlog', 1)
    RETURNING id INTO v_col_id_b1;
    
    INSERT INTO COLUMNS (project_id, name, position)
    VALUES (v_project_id_b, 'Testing', 2)
    RETURNING id INTO v_col_id_b2;

    INSERT INTO TASKS (project_id, column_id, name)
    VALUES (v_project_id_a, v_col_id_a1, 'Design Home Page Mockup'),
           (v_project_id_a, v_col_id_a1, 'Write new landing page copy');
           
    INSERT INTO TASKS (project_id, column_id, name)
    VALUES (v_project_id_a, v_col_id_a2, 'Define color palette');

    INSERT INTO TASKS (project_id, column_id, name)
    VALUES (v_project_id_b, v_col_id_b1, 'Research API documentation standard'),
           (v_project_id_b, v_col_id_b1, 'Migrate user service to microservice');
           
    INSERT INTO TASKS (project_id, column_id, name)
    VALUES (v_project_id_b, v_col_id_b2, 'Verify user login persistence');
    
END $$;
