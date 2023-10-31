/*User - jonas 1234*/
/*Agent - samu2k 1234*/

INSERT INTO users (name, username, email, password, role, department_id)
VALUES 
    ('joao', 'jonas', 'jonas@gmail.com', '$2y$12$wZVmdyhmuUCiwkVyyfEIt.zvw9gCRlO1IAsEz6d2f7WgYacttNRjS', 'user', 6),
    ('samu', 'samu2k', 'samu2k@gmail.com', '$2y$12$wZVmdyhmuUCiwkVyyfEIt.zvw9gCRlO1IAsEz6d2f7WgYacttNRjS', 'agent', 1),
    ('pessoa', 'pessoa', 'pessoa@gmail.com', '$2y$12$wZVmdyhmuUCiwkVyyfEIt.zvw9gCRlO1IAsEz6d2f7WgYacttNRjS', 'admin', 6),
    ('paulo', 'paulo', 'paulo@gmail.com','zfsajfksdjh','agent',1);


INSERT INTO tickets (user_id, title, description, date, status, priority, assigned_to, department_id)
VALUES
    (1, 'Random Titlez' , 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc luctus sapien nec nunc varius, sed rutrum dui tincidunt. Curabitur erat nunc, consequat sed eleifend in, placerat ut neque. Donec ut dui malesuada, malesuada ipsum ut, pretium enim. Curabitur bibendum suscipit purus, quis tristique mi ultrices vel. Vestibulum eget tempor mi.', '2022-03-01 10:00:00', 'Open', 'High', NULL, 1),
    (1, 'Random Titlez1' , 'Email not sending', '2022-03-01 12:00:00', 'Open', 'Low', 2, 4),
    (1, 'Random Titlez2' , 'Software not working', '2022-03-02 09:00:00', 'Open', 'Medium', 2, 1),
    (1, 'Random Titlez3' , 'Can''t login to the system', '2022-03-02 14:00:00', 'Closed', 'High', NULL, 2),
    (1, 'Random Titlez4' , 'Software not working', '2022-03-02 09:00:00', 'Open', 'Medium', NULL, 1),
    (1, 'Random Titlez5' , 'Can''t login to the system', '2022-03-02 14:00:00', 'Closed', 'High', 2, 2),
    (1, 'Random Titlez6' , 'Software not working', '2022-03-02 09:00:00', 'Open', 'Medium', NULL, 1),
    (1, 'Random Titlez7' , 'Can''t login to the system', '2022-03-02 14:00:00', 'Closed', 'High', NULL, 2);

INSERT INTO departments (department_name) VALUES
    ('Sales'),
    ('Marketing'),
    ('Human Resources'),
    ('Finance'),
    ('IT'),
    ('Unassigned');

INSERT INTO ticket_hashtags(ticket_id,hashtag_id) VALUES
(1,1),
(2,2),
(3,1),
(4,2),
(5,3),
(6,2),
(7,1),
(8,2),
(9,3);

INSERT INTO hashtags (hashtag_id, name) VALUES
(1, '#tech'),
(2, '#internet'),
(3, '#email');

INSERT INTO comment (description, date, ticket_id, user_id) VALUES
  ('This is the first comment on ticket 1', '2022-01-01 10:00:00', 1, 1),
  ('This is the second comment on ticket 1', '2022-01-02 12:00:00', 1, 2),
  ('This is the first comment on ticket 2', '2022-01-03 14:00:00', 2, 3),
  ('This is the second comment on ticket 2', '2022-01-04 16:00:00', 2, 1),
  ('This is the first comment on ticket 3', '2022-01-05 18:00:00', 3, 2),
  ('This is the second comment on ticket 3', '2022-01-06 20:00:00', 3, 3);

INSERT INTO faq (faq_id,question, answer)
VALUES (1,'How do I submit a ticket?', 'To submit a ticket, navigate to the "Support" or "Help" section of our website. Click on the "Submit a Ticket" button and fill out the required information in the ticket submission form. Once submitted, you will receive a confirmation email with your ticket details.'),
 (2,'How long does it take to receive a response to my ticket?', 'We strive to respond to all tickets within 24 hours of submission. However, during peak times, it may take slightly longer. Rest assured that our support team is working diligently to address your issue, and we appreciate your patience.'),
 (3,'Can I track the status of my ticket?', 'Yes, you can track the status of your ticket by logging into your account and visiting the "My Tickets" or "Support History" section. There, you will find a list of your submitted tickets along with their current status and any updates provided by our support team.'),
 (4,'What information should I include in my ticket for faster assistance?', 'To help us assist you more efficiently, please provide detailed information about the problem you are facing. Include any error messages, steps to reproduce the issue, and relevant account or order details. The more information you provide, the quicker we can diagnose and resolve your problem.'),
 (5,'Can I reopen a closed ticket if my issue persists?', 'Absolutely! If your problem persists or you have related questions, you can reopen a closed ticket by replying to the ticket email thread or contacting our support team. We''re here to help and will gladly assist you further.');


INSERT INTO ticket_change (ticket_id, change_date, title, description, date, status, priority, assigned_to, department_id)
VALUES
    (1, '2022-03-01 10:00:00', 'Updated Title 1', 'Updated description 1', '2022-03-01 10:00:00', 'Open', 'High', 2, 1),
    (1, '2022-03-02 09:00:00', 'Updated Title 2', 'Updated description 2', '2022-03-02 09:00:00', 'Open', 'Medium', NULL, 1),
    (1, '2022-03-02 14:00:00', 'Updated Title 3', 'Updated description 3', '2022-03-02 14:00:00', 'Closed', 'High', NULL, 2);
