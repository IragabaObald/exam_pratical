<?php
require_once 'db.php';

$message = '';
$error = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'add_class') {
            $stmt = $pdo->prepare("INSERT INTO classes (class_name, academic_year) VALUES (?, ?)");
            $stmt->execute([$_POST['class_name'], $_POST['academic_year']]);
            $message = "Class added successfully!";
        } 
        elseif ($action === 'add_student') {
            $stmt = $pdo->prepare("INSERT INTO students (admission_number, names, gender, date_of_birth, class_id, phone_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['admission_number'],
                $_POST['names'],
                $_POST['gender'],
                $_POST['date_of_birth'],
                $_POST['class_id'],
                $_POST['phone_number'],
                $_POST['address']
            ]);
            $message = "Student added successfully!";
        } 
        elseif ($action === 'add_subject') {
            $stmt = $pdo->prepare("INSERT INTO subjects (subject_name, subject_code) VALUES (?, ?)");
            $stmt->execute([$_POST['subject_name'], $_POST['subject_code']]);
            $message = "Subject added successfully!";
        } 
        elseif ($action === 'record_attendance') {
            $stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, attendance_status) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['student_id'], $_POST['date'], $_POST['attendance_status']]);
            $message = "Attendance recorded!";
        } 
        elseif ($action === 'add_grade') {
            $stmt = $pdo->prepare("INSERT INTO grades (student_id, subject_id, assessment_type, marks, academic_year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['student_id'],
                $_POST['subject_id'],
                $_POST['assessment_type'],
                $_POST['marks'],
                $_POST['academic_year']
            ]);
            $message = "Grade recorded!";
        } 
        elseif ($action === 'add_announcement') {
            // Using user_id 1 for demo purposes
            $stmt = $pdo->prepare("INSERT INTO announcements (title, message, posted_by) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['title'], $_POST['message'], 1]);
            $message = "Announcement published!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch lists for forms and tables
$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();
$subjects = $pdo->query("SELECT * FROM subjects ORDER BY subject_name")->fetchAll();
$students = $pdo->query("SELECT s.*, c.class_name FROM students s LEFT JOIN classes c ON s.class_id = c.class_id ORDER BY s.student_id DESC")->fetchAll();
$attendance = $pdo->query("SELECT a.*, s.names FROM attendance a JOIN students s ON a.student_id = s.student_id ORDER BY a.date DESC LIMIT 10")->fetchAll();
$grades = $pdo->query("SELECT g.*, s.names, sub.subject_name FROM grades g JOIN students s ON g.student_id = s.student_id JOIN subjects sub ON g.subject_id = sub.subject_id ORDER BY g.grade_id DESC LIMIT 10")->fetchAll();
$announcements = $pdo->query("SELECT a.*, u.username FROM announcements a JOIN users u ON a.posted_by = u.user_id ORDER BY a.publication_date DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOL SMS  School Management System</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        h1 { text-align: center; color: #1e293b; margin-bottom: 20px; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 6px; font-weight: bold; text-align: center; }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .card h2 { margin-top: 0; color: #2563eb; font-size: 1.25rem; border-bottom: 2px solid #eff6ff; padding-bottom: 8px; }
        form { display: flex; flex-direction: column; gap: 12px; margin-bottom: 15px; }
        label { font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: -6px; }
        input, select, textarea { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #2563eb; }
        button { background: #2563eb; color: white; border: none; padding: 10px; border-radius: 4px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.85rem; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; color: #475569; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
        .Present { background: #d1fae5; color: #065f46; }
        .Absent { background: #fee2e2; color: #991b1b; }
        .Late { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>

    <h1>🏫 LOL School Management System</h1>

    <?php if ($message): ?>
        <div class="alert success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="grid">

        <!-- 1. ADD CLASS -->
        <div class="card">
            <h2>1. Classes</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add_class">
                <label>Class Name</label>
                <input type="text" name="class_name" placeholder=" ICT" required>
                <label>Academic Year</label>
                <input type="text" name="academic_year" placeholder="2026-2027" required>
                <button type="submit">Add Class</button>
            </form>
            <h3>Existing Classes</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Year</th>
                </tr>
                <?php foreach ($classes as $c): ?>
                    <tr>
                        <td><?= $c['class_id'] ?></td>
                        <td><?= htmlspecialchars($c['class_name']) ?></td>
                        <td><?= htmlspecialchars($c['academic_year']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 2. ADD SUBJECT -->
        <div class="card">
            <h2>2. Subjects</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add_subject">
                <label>Subject Name</label>
                <input type="text" name="subject_name" placeholder="e.g. Mathematics" required>
                <label>Subject Code</label>
                <input type="text" name="subject_code" placeholder="e.g. MATH101" required>
                <button type="submit">Add Subject</button>
            </form>
            <h3>Existing Subjects</h3>
            <table>
                <tr>
                    <th>Code</th>
                    <th>Subject Name</th>
                </tr>
                <?php foreach ($subjects as $sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['subject_code']) ?></td>
                        <td><?= htmlspecialchars($sub['subject_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 3. ADD STUDENT -->
        <div class="card">
            <h2>3. Register Student</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add_student">
                <label>Admission No</label>
                <input type="text" name="admission_number" placeholder="e.g. ADM2026001" required>
                <label>Full Names</label>
                <input type="text" name="names" placeholder="Full Name" required>
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" required>
                <label>Class</label>
                <select name="class_id" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= $c['class_id'] ?>"><?= htmlspecialchars($c['class_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Phone Number</label>
                <input type="text" name="phone_number" placeholder="+250...">
                <label>Address</label>
                <input type="text" name="address" placeholder="City / Location">
                <button type="submit">Register Student</button>
            </form>
        </div>

        <!-- 4. RECORD ATTENDANCE -->
        <div class="card">
            <h2>4. Record Attendance</h2>
            <form method="POST">
                <input type="hidden" name="action" value="record_attendance">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['names']) ?> (<?= htmlspecialchars($s['admission_number']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <label>Date</label>
                <input type="date" name="date" value="<?= date('Y-m-d') ?>" required>
                <label>Status</label>
                <select name="attendance_status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Late">Late</option>
                </select>
                <button type="submit">Record Attendance</button>
            </form>

            <h3>Recent Attendance Records</h3>
            <table>
                <tr><th>Student</th><th>Date</th><th>Status</th></tr>
                <?php foreach ($attendance as $att): ?>
                    <tr>
                        <td><?= htmlspecialchars($att['names']) ?></td>
                        <td><?= $att['date'] ?></td>
                        <td><span class="badge <?= $att['attendance_status'] ?>"><?= $att['attendance_status'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 5. RECORD GRADES -->
        <div class="card">
            <h2>5. Record Marks & Grades</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add_grade">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['names']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Subject</label>
                <select name="subject_id" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $sub): ?>
                        <option value="<?= $sub['subject_id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label>Assessment Type</label>
                <input type="text" name="assessment_type" placeholder="e.g. Midterm, Final Exam" required>
                <label>Marks Obtained</label>
                <input type="number" step="0.01" name="marks" placeholder="0 - 100" required>
                <label>Academic Year</label>
                <input type="text" name="academic_year" value="2026" required>
                <button type="submit">Submit Marks</button>
            </form>

            <h3>Recent Grade Entries</h3>
            <table>
                <tr><th>Student</th><th>Subject</th><th>Marks</th></tr>
                <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?= htmlspecialchars($g['names']) ?></td>
                        <td><?= htmlspecialchars($g['subject_name']) ?></td>
                        <td><strong><?= htmlspecialchars($g['marks']) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 6. POST ANNOUNCEMENT -->
        <div class="card">
            <h2>6. Post Announcement</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add_announcement">
                <label>Title</label>
                <input type="text" name="title" placeholder="Announcement Title" required>
                <label>Message</label>
                <textarea name="message" rows="3" placeholder="Write message here..." required></textarea>
                <button type="submit">Publish</button>
            </form>

            <h3>Announcements</h3>
            <?php foreach ($announcements as $anc): ?>
                <div style="background:#f8fafc; border-left: 3px solid #2563eb; padding: 8px; margin-bottom: 10px;">
                    <strong><?= htmlspecialchars($anc['title']) ?></strong>
                    <p style="margin: 4px 0; font-size: 0.85rem;"><?= htmlspecialchars($anc['message']) ?></p>
                    <small style="color: #64748b;"><?= $anc['publication_date'] ?> | Posted by: <?= htmlspecialchars($anc['username']) ?></small>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- REGISTERED STUDENTS TABLE -->
    <div class="card" style="margin-top: 20px;">
        <h2>Registered Students Directory</h2>
        <table>
            <thead>
                <tr>
                    <th>Adm No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Class</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr><td colspan="7">No students registered yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['admission_number']) ?></td>
                            <td><?= htmlspecialchars($s['names']) ?></td>
                            <td><?= htmlspecialchars($s['gender']) ?></td>
                            <td><?= htmlspecialchars($s['date_of_birth']) ?></td>
                            <td><?= htmlspecialchars($s['class_name'] ?? 'Unassigned') ?></td>
                            <td><?= htmlspecialchars($s['phone_number']) ?></td>
                            <td><?= htmlspecialchars($s['address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>