CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,  
    username TEXT NOT NULL UNIQUE,     
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL,
    department_id INTEGER REFERENCES departments(department_id)
);


CREATE TABLE departments (
    department_id INTEGER PRIMARY KEY AUTOINCREMENT,
    department_name TEXT NOT NULL
);

CREATE TABLE tickets (
    ticket_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER REFERENCES users(id),
    title VARCHAR(50),
    description VARCHAR(300),
    date DATETIME,
    status VARCHAR(20),
    priority VARCHAR(20),
    assigned_to INTEGER REFERENCES users(id),
    department_id INTEGER REFERENCES departments(department_id)
);

CREATE TABLE ticket_change (
  version_id INTEGER PRIMARY KEY AUTOINCREMENT,
  ticket_id INTEGER REFERENCES tickets(ticket_id),
  change_date DATETIME, 
  title VARCHAR(50),
  description VARCHAR(300),
  date DATETIME,
  status VARCHAR(20),
  priority VARCHAR(20),
  assigned_to INTEGER REFERENCES users(id),
  department_id INTEGER REFERENCES departments(department_id)
);

CREATE TABLE ticket_users ( -- several users can be asssociated with the same ticket
  ticket_id INTEGER REFERENCES tickets(ticket_id),
  user_id INTEGER REFERENCES users(user_id)
  --só agents é que podem associar tickets a users
  --verificar se é agent em SQL?
);



CREATE TABLE department_users ( -- several agents can be asssociated with the same department
  department_id INTEGER REFERENCES department(department_id),
  user_id INTEGER REFERENCES users(user_id)
  --só admins é que podem associar Agents a departamentos
  --verificar se é Admin em SQL?
);


CREATE TABLE hashtags (
  hashtag_id INTEGER PRIMARY KEY,
  name VARCHAR(50)
);

CREATE TABLE ticket_hashtags ( 
  ticket_id INTEGER REFERENCES tickets(ticket_id),
  hashtag_id INTEGER REFERENCES hashtags(hashtag_id)
);


CREATE TABLE comment ( -- inquirues e replys sao tudo comments
  comment_id INTEGER PRIMARY KEY AUTOINCREMENT,
  description VARCHAR(300),
  date DATETIME,
  ticket_id INTEGER REFERENCES tickets(ticket_id),
  user_id INTEGER REFERENCES users(user_id)
);

CREATE TABLE faq (
  faq_id INT PRIMARY KEY,
  question TEXT,
  answer TEXT
);

