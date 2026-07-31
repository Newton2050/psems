-- database/seed.sql
-- Seed data for PSEMs school database. Run after importing school.sql (USE psems_school;)

USE psems_school;

-- Schools
INSERT INTO schools (name, address) VALUES
('Central High School', '123 Main St'),
('Westside Prep', '456 West Ave');

-- Users: admin, teachers, students (passwords are placeholders - store hashed passwords in real deployments)
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@example.com', 'password_hash_here', 'admin'),
('ms_olivia', 'olivia.teacher@example.com', 'password_hash_here', 'teacher'),
('mr_jones', 'jones.teacher@example.com', 'password_hash_here', 'teacher'),
('student_anna', 'anna.student@example.com', 'password_hash_here', 'student'),
('student_bob', 'bob.student@example.com', 'password_hash_here', 'student');

-- Classes
INSERT INTO classes (school_id, name, code, description) VALUES
(1, 'Mathematics 101', 'MATH101', 'Introductory Mathematics course'),
(1, 'English Literature', 'ENG101', 'English literature basics'),
(2, 'Physics 101', 'PHY101', 'Introductory Physics');

-- Enrollments
INSERT INTO enrollments (class_id, student_id) VALUES
(1, 4),
(1, 5),
(2, 4);

-- Assignments
INSERT INTO assignments (class_id, title, description, due_date) VALUES
(1, 'Algebra Homework', 'Solve problems 1-10', NOW() + INTERVAL 7 DAY),
(2, 'Essay: Poetry', 'Write an essay on assigned poem', NOW() + INTERVAL 10 DAY);

-- Submissions (placeholders)
INSERT INTO submissions (assignment_id, student_id, file_path, grade) VALUES
(1, 4, 'uploads/annalgebra.pdf', NULL),
(2, 4, 'uploads/annaessay.docx', 'A-');
