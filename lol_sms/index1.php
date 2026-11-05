<?php
require_once 'db.php';

$message = '';$error = '';

// Handle Form Submissions & Actions (CREATE, UPDATE, DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action =$_POST['action'] ?? '';

    try {
        // --- 1. CLASSES ACTIONS ---
        if ($action === 'add_class') {
            $stmt =$pdo->prepare("INSERT INTO classes (class_name, academic_year) VALUES (?, ?)");
            $stmt->execute([$_POST['class_name'], $_POST['academic_year']]);$message = "Class added successfully!";
        } elseif ($action === 'update_class') {
            $stmt =$pdo->prepare("UPDATE classes SET class_name = ?, academic_year = ? WHERE class_id = ?");
            $stmt->execute([$_POST['class_name'],$_POST['academic_year'], $_POST['class_id']]);$message = "Class updated successfully!";
        } elseif ($action === 'delete_class') {
            $stmt =$pdo->prepare("DELETE FROM classes WHERE class_id = ?");
            $stmt->execute([$_POST['class_id']]);$message = "Class deleted successfully!";
        }

        // --- 2. SUBJECTS ACTIONS ---
        elseif ($action === 'add_subject') {
            $stmt =$pdo->prepare("INSERT INTO subjects (subject_name, subject_code) VALUES (?, ?)");
            $stmt->execute([$_POST['subject_name'], $_POST['subject_code']]);$message = "Subject added successfully!";
        } elseif ($action === 'update_subject') {
            $stmt =$pdo->prepare("UPDATE subjects SET subject_name = ?, subject_code = ? WHERE subject_id = ?");
            $stmt->execute([$_POST['subject_name'],$_POST['subject_code'], $_POST['subject_id']]);$message = "Subject updated successfully!";
        } elseif ($action === 'delete_subject') {
            $stmt =$pdo->prepare("DELETE FROM subjects WHERE subject_id = ?");
            $stmt->execute([$_POST['subject_id']]);$message = "Subject deleted successfully!";
        }

        // --- 3. STUDENTS ACTIONS ---
        elseif ($action === 'add_student') {
            $stmt =$pdo->prepare("INSERT INTO students (admission_number, names, gender, date_of_birth, class_id, phone_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['admission_number'],
                $_POST['names'],$_POST['gender'],
                $_POST['date_of_birth'],$_POST['class_id'],
                $_POST['phone_number'],$_POST['address']
            ]);
            $message = "Student registered successfully!";
        } elseif ($action === 'update_student') {
            $stmt =$pdo->prepare("UPDATE students SET admission_number = ?, names = ?, gender = ?, date_of_birth = ?, class_id = ?, phone_number = ?, address = ? WHERE student_id = ?");
            $stmt->execute([
                $_POST['admission_number'],$_POST['names'],
                $_POST['gender'],$_POST['date_of_birth'],
                $_POST['class_id'],$_POST['phone_number'],
                $_POST['address'],$_POST['student_id']
            ]);
            $message = "Student information updated successfully!";
        } elseif ($action === 'delete_student') {
            $stmt =$pdo->prepare("DELETE FROM students WHERE student_id = ?");
            $stmt->execute([$_POST['student_id']]);$message = "Student deleted successfully!";
        }

        // --- 4. ATTENDANCE ACTIONS ---
        elseif ($action === 'record_attendance') {
            $stmt =$pdo->prepare("INSERT INTO attendance (student_id, date, attendance_status) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['student_id'],$_POST['date'], $_POST['attendance_status']]);$message = "Attendance recorded!";
        } elseif ($action === 'update_attendance') {
            $stmt =$pdo->prepare("UPDATE attendance SET student_id = ?, date = ?, attendance_status = ? WHERE attendance_id = ?");
            $stmt->execute([$_POST['student_id'], $_POST['date'],$_POST['attendance_status'], $_POST['attendance_id']]);$message = "Attendance record updated!";
        } elseif ($action === 'delete_attendance') {
            $stmt =$pdo->prepare("DELETE FROM attendance WHERE attendance_id = ?");
            $stmt->execute([$_POST['attendance_id']]);$message = "Attendance record deleted!";
        }

        // --- 5. GRADES ACTIONS ---
        elseif ($action === 'add_grade') {
            $stmt =$pdo->prepare("INSERT INTO grades (student_id, subject_id, assessment_type, marks, academic_year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['student_id'],
                $_POST['subject_id'],$_POST['assessment_type'],
                $_POST['marks'],$_POST['academic_year']
            ]);
            $message = "Grade recorded!";
        } elseif ($action === 'update_grade') {
            $stmt =$pdo->prepare("UPDATE grades SET student_id = ?, subject_id = ?, assessment_type = ?, marks = ?, academic_year = ? WHERE grade_id = ?");
            $stmt->execute([
                $_POST['student_id'],$_POST['subject_id'],
                $_POST['assessment_type'],$_POST['marks'],
                $_POST['academic_year'],$_POST['grade_id']
            ]);
            $message = "Grade updated successfully!";
        } elseif ($action === 'delete_grade') {
            $stmt =$pdo->prepare("DELETE FROM grades WHERE grade_id = ?");
            $stmt->execute([$_POST['grade_id']]);$message = "Grade deleted successfully!";
        }

        // --- 6. ANNOUNCEMENTS ACTIONS ---
        elseif ($action === 'add_announcement') {
            $stmt =$pdo->prepare("INSERT INTO announcements (title, message, posted_by) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['title'], $_POST['message'], 1]);$message = "Announcement published!";
        } elseif ($action === 'update_announcement') {
            $stmt =$pdo->prepare("UPDATE announcements SET title = ?, message = ? WHERE announcement_id = ?");
            $stmt->execute([$_POST['title'],$_POST['message'], $_POST['announcement_id']]);$message = "Announcement updated!";
        } elseif ($action === 'delete_announcement') {
            $stmt =$pdo->prepare("DELETE FROM announcements WHERE announcement_id = ?");
            $stmt->execute([$_POST['announcement_id']]);$message = "Announcement deleted!";
        }
    } catch (PDOException $e) {$error = "Database Error: " . $e->getMessage();
    }
}

// Fetch lists for rendering forms and tables
$classes =$pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();
$subjects =$pdo->query("SELECT * FROM subjects ORDER BY subject_name")->fetchAll();
$students =$pdo->query("SELECT s.*, c.class_name FROM students s LEFT JOIN classes c ON s.class_id = c.class_id ORDER BY s.student_id DESC")->fetchAll();
$attendance =$pdo->query("SELECT a.*, s.names FROM attendance a JOIN students s ON a.student_id = s.student_id ORDER BY a.date DESC LIMIT 10")->fetchAll();
$grades =$pdo->query("SELECT g.*, s.names, sub.subject_name FROM grades g JOIN students s ON g.student_id = s.student_id JOIN subjects sub ON g.subject_id = sub.subject_id ORDER BY g.grade_id DESC LIMIT 10")->fetchAll();
$announcements =$pdo->query("SELECT a.*, u.username FROM announcements a JOIN users u ON a.posted_by = u.user_id ORDER BY a.publication_date DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOL SMS - School Management System</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        h1 { text-align: center; color: #1e293b; margin-bottom: 20px; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 6px; font-weight: bold; text-align: center; }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .card-header-flex { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eff6ff; padding-bottom: 8px; margin-bottom: 12px; }
        .card h2 { margin: 0; color: #2563eb; font-size: 1.25rem; }
        form { display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px; }
        label { font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: -4px; }
        input, select, textarea { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #2563eb; }
        button { background: #2563eb; color: white; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #1d4ed8; }
        button.btn-warning { background: #f59e0b; }
        button.btn-warning:hover { background: #d97706; }
        button.btn-danger { background: #ef4444; }
        button.btn-danger:hover { background: #dc2626; }
        button.btn-print { background: #0f766e; }
        button.btn-print:hover { background: #115e59; }
        button.btn-sm { padding: 4px 8px; font-size: 0.75rem; }
        .action-btns { display: flex; gap: 4px; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.85rem; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        th { background: #f8fafc; color: #475569; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
        .Present { background: #d1fae5; color: #065f46; }
        .Absent { background: #fee2e2; color: #991b1b; }
        .Late { background: #fef3c7; color: #92400e; }

        /* Modal Popup Styles */
        .modal { display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 25px; border-radius: 8px; width: 90%; max-width: 500px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .modal-header h3 { margin: 0; color: #1e293b; }
        .close-btn { background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; padding: 0; }
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

        <!-- 1. CLASSES CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>1. Classes</h2>
                <button class="btn-print btn-sm" onclick="printTableSection('Classes Report', 'tblClasses')">🖨️ Print Report</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_class">
                <label>Class Name</label>
                <input type="text" name="class_name" placeholder="e.g. Form 1A" required>
                <label>Academic Year</label>
                <input type="text" name="academic_year" placeholder="e.g. 2026" required>
                <button type="submit">Add Class</button>
            </form>

            <h3>Existing Classes</h3>
            <table id="tblClasses">
                <tr><th>ID</th><th>Name</th><th>Year</th><th class="no-print">Actions</th></tr>
                <?php foreach ($classes as$c): ?>
                    <tr>
                        <td><?= $c['class_id'] ?></td>
                        <td><?= htmlspecialchars($c['class_name']) ?></td>
                        <td><?= htmlspecialchars($c['academic_year']) ?></td>
                        <td class="no-print">
                            <div class="action-btns">
                                <button class="btn-warning btn-sm" onclick='editClass(<?= json_encode($c) ?>)'>Edit</button>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this class?');">
                                    <input type="hidden" name="action" value="delete_class">
                                    <input type="hidden" name="class_id" value="<?= $c['class_id'] ?>">
                                    <button type="submit" class="btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 2. SUBJECTS CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>2. Subjects</h2>
                <button class="btn-print btn-sm" onclick="printTableSection('Subjects Report', 'tblSubjects')">🖨️ Print Report</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_subject">
                <label>Subject Name</label>
                <input type="text" name="subject_name" placeholder="e.g. Mathematics" required>
                <label>Subject Code</label>
                <input type="text" name="subject_code" placeholder="e.g. MATH101" required>
                <button type="submit">Add Subject</button>
            </form>

            <h3>Existing Subjects</h3>
            <table id="tblSubjects">
                <tr><th>Code</th><th>Subject Name</th><th class="no-print">Actions</th></tr>
                <?php foreach ($subjects as$sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['subject_code']) ?></td>
                        <td><?= htmlspecialchars($sub['subject_name']) ?></td>
                        <td class="no-print">
                            <div class="action-btns">
                                <button class="btn-warning btn-sm" onclick='editSubject(<?= json_encode($sub) ?>)'>Edit</button>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this subject?');">
                                    <input type="hidden" name="action" value="delete_subject">
                                    <input type="hidden" name="subject_id" value="<?= $sub['subject_id'] ?>">
                                    <button type="submit" class="btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 3. ADD STUDENT CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>3. Register Student</h2>
            </div>
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
                    <?php foreach ($classes as$c): ?>
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

        <!-- 4. ATTENDANCE CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>4. Record Attendance</h2>
                <button class="btn-print btn-sm" onclick="printTableSection('Attendance Report', 'tblAttendance')">🖨️ Print Report</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="record_attendance">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as$s): ?>
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
            <table id="tblAttendance">
                <tr><th>Student</th><th>Date</th><th>Status</th><th class="no-print">Actions</th></tr>
                <?php foreach ($attendance as$att): ?>
                    <tr>
                        <td><?= htmlspecialchars($att['names']) ?></td>
                        <td><?= $att['date'] ?></td>
                        <td><span class="badge <?= $att['attendance_status'] ?>"><?= $att['attendance_status'] ?></span></td>
                        <td class="no-print">
                            <div class="action-btns">
                                <button class="btn-warning btn-sm" onclick='editAttendance(<?= json_encode($att) ?>)'>Edit</button>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete attendance entry?');">
                                    <input type="hidden" name="action" value="delete_attendance">
                                    <input type="hidden" name="attendance_id" value="<?= $att['attendance_id'] ?>">
                                    <button type="submit" class="btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 5. GRADES CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>5. Record Marks & Grades</h2>
                <button class="btn-print btn-sm" onclick="printTableSection('Grades Report', 'tblGrades')">🖨️ Print Report</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_grade">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as$s): ?>
                        <option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['names']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Subject</label>
                <select name="subject_id" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as$sub): ?>
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
            <table id="tblGrades">
                <tr><th>Student</th><th>Subject</th><th>Marks</th><th class="no-print">Actions</th></tr>
                <?php foreach ($grades as$g): ?>
                    <tr>
                        <td><?= htmlspecialchars($g['names']) ?></td>
                        <td><?= htmlspecialchars($g['subject_name']) ?></td>
                        <td><strong><?= htmlspecialchars($g['marks']) ?></strong></td>
                        <td class="no-print">
                            <div class="action-btns">
                                <button class="btn-warning btn-sm" onclick='editGrade(<?= json_encode($g) ?>)'>Edit</button>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this grade record?');">
                                    <input type="hidden" name="action" value="delete_grade">
                                    <input type="hidden" name="grade_id" value="<?= $g['grade_id'] ?>">
                                    <button type="submit" class="btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- 6. ANNOUNCEMENTS CARD -->
        <div class="card">
            <div class="card-header-flex">
                <h2>6. Announcements</h2>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_announcement">
                <label>Title</label>
                <input type="text" name="title" placeholder="Announcement Title" required>
                <label>Message</label>
                <textarea name="message" rows="3" placeholder="Write message here..." required></textarea>
                <button type="submit">Publish</button>
            </form>

            <h3>Recent Posts</h3>
            <?php foreach ($announcements as$anc): ?>
                <div style="background:#f8fafc; border-left: 3px solid #2563eb; padding: 10px; margin-bottom: 10px;">
                    <strong><?= htmlspecialchars($anc['title']) ?></strong>
                    <p style="margin: 4px 0; font-size: 0.85rem;"><?= htmlspecialchars($anc['message']) ?></p>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top: 6px;">
                        <small style="color: #64748b;"><?= $anc['publication_date'] ?></small>
                        <div class="action-btns">
                            <button class="btn-warning btn-sm" onclick='editAnnouncement(<?= json_encode($anc) ?>)'>Edit</button>
                            <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this announcement?');">
                                <input type="hidden" name="action" value="delete_announcement">
                                <input type="hidden" name="announcement_id" value="<?= $anc['announcement_id'] ?>">
                                <button type="submit" class="btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- REGISTERED STUDENTS DIRECTORY TABLE -->
    <div class="card" style="margin-top: 20px;">
        <div class="card-header-flex">
            <h2>Registered Students Directory</h2>
            <button class="btn-print btn-sm" onclick="printTableSection('Students Directory Report', 'tblStudents')">🖨️ Print Report</button>
        </div>
        <table id="tblStudents">
            <thead>
                <tr>
                    <th>Adm No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Class</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th class="no-print">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr><td colspan="8">No students registered yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($students as$s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['admission_number']) ?></td>
                            <td><?= htmlspecialchars($s['names']) ?></td>
                            <td><?= htmlspecialchars($s['gender']) ?></td>
                            <td><?= htmlspecialchars($s['date_of_birth']) ?></td>
                            <td><?= htmlspecialchars($s['class_name'] ?? 'Unassigned') ?></td>
                            <td><?= htmlspecialchars($s['phone_number']) ?></td>
                            <td><?= htmlspecialchars($s['address']) ?></td>
                            <td class="no-print">
                                <div class="action-btns">
                                    <button class="btn-warning btn-sm" onclick='editStudent(<?= json_encode($s) ?>)'>Edit</button>
                                    <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this student record?');">
                                        <input type="hidden" name="action" value="delete_student">
                                        <input type="hidden" name="student_id" value="<?= $s['student_id'] ?>">
                                        <button type="submit" class="btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL FOR EDITING RECORDS -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Record</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById('editModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('editModal').style.display = 'none'; }

        // Print Report Function
        function printTableSection(title, tableId) {
            let tableElement = document.getElementById(tableId);
            if (!tableElement) return;

            let printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>${title}</title>
                    <style>
                        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; color: #333; }
                        h2 { text-align: center; color: #1e293b; margin-bottom: 5px; }
                        h4 { text-align: center; color: #64748b; margin-top: 0; margin-bottom: 25px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px; }
                        th, td { border: 1px solid #cbd5e1; padding: 8px 12px; text-align: left; }
                        th { background: #f8fafc; color: #475569; }
                        .no-print { display: none !important; }
                    </style>
                </head>
                <body>
                    <h2>🏫 LOL School Management System</h2>
                    <h4>${title}</h4>
                    ${tableElement.outerHTML}
                    <script>
                        window.onload = function() { window.print(); window.close(); }
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        function editClass(data) {
            document.getElementById('modalTitle').innerText = 'Edit Class';
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_class">
                    <input type="hidden" name="class_id" value="${data.class_id}">
                    <label>Class Name</label>
                    <input type="text" name="class_name" value="${data.class_name}" required>
                    <label>Academic Year</label>
                    <input type="text" name="academic_year" value="${data.academic_year}" required>
                    <button type="submit" class="btn-warning">Update Class</button>
                </form>`;
            openModal();
        }

        function editSubject(data) {
            document.getElementById('modalTitle').innerText = 'Edit Subject';
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_subject">
                    <input type="hidden" name="subject_id" value="${data.subject_id}">
                    <label>Subject Name</label>
                    <input type="text" name="subject_name" value="${data.subject_name}" required>
                    <label>Subject Code</label>
                    <input type="text" name="subject_code" value="${data.subject_code}" required>
                    <button type="submit" class="btn-warning">Update Subject</button>
                </form>`;
            openModal();
        }

        function editStudent(data) {
            document.getElementById('modalTitle').innerText = 'Edit Student';
            let classOptions = `<?php foreach ($classes as $c): ?><option value="<?= $c['class_id'] ?>"><?= htmlspecialchars($c['class_name']) ?></option><?php endforeach; ?>`;
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_student">
                    <input type="hidden" name="student_id" value="${data.student_id}">
                    <label>Admission No</label>
                    <input type="text" name="admission_number" value="${data.admission_number}" required>
                    <label>Full Names</label>
                    <input type="text" name="names" value="${data.names}" required>
                    <label>Gender</label>
                    <select name="gender" id="edit_gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="${data.date_of_birth}" required>
                    <label>Class</label>
                    <select name="class_id" id="edit_class_id" required>${classOptions}</select>
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" value="${data.phone_number}">
                    <label>Address</label>
                    <input type="text" name="address" value="${data.address}">
                    <button type="submit" class="btn-warning">Update Student</button>
                </form>`;
            document.getElementById('edit_gender').value = data.gender;
            document.getElementById('edit_class_id').value = data.class_id;
            openModal();
        }

        function editAttendance(data) {
            document.getElementById('modalTitle').innerText = 'Edit Attendance Record';
            let studentOptions = `<?php foreach ($students as $s): ?><option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['names']) ?></option><?php endforeach; ?>`;
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_attendance">
                    <input type="hidden" name="attendance_id" value="${data.attendance_id}">
                    <label>Student</label>
                    <select name="student_id" id="edit_att_student" required>${studentOptions}</select>
                    <label>Date</label>
                    <input type="date" name="date" value="${data.date}" required>
                    <label>Status</label>
                    <select name="attendance_status" id="edit_att_status" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                    </select>
                    <button type="submit" class="btn-warning">Update Attendance</button>
                </form>`;
            document.getElementById('edit_att_student').value = data.student_id;
            document.getElementById('edit_att_status').value = data.attendance_status;
            openModal();
        }

        function editGrade(data) {
            document.getElementById('modalTitle').innerText = 'Edit Grade Record';
            let studentOptions = `<?php foreach ($students as $s): ?><option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['names']) ?></option><?php endforeach; ?>`;
            let subjectOptions = `<?php foreach ($subjects as $sub): ?><option value="<?= $sub['subject_id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option><?php endforeach; ?>`;
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_grade">
                    <input type="hidden" name="grade_id" value="${data.grade_id}">
                    <label>Student</label>
                    <select name="student_id" id="edit_grd_student" required>${studentOptions}</select>
                    <label>Subject</label>
                    <select name="subject_id" id="edit_grd_subject" required>${subjectOptions}</select>
                    <label>Assessment Type</label>
                    <input type="text" name="assessment_type" value="${data.assessment_type}" required>
                    <label>Marks</label>
                    <input type="number" step="0.01" name="marks" value="${data.marks}" required>
                    <label>Academic Year</label>
                    <input type="text" name="academic_year" value="${data.academic_year}" required>
                    <button type="submit" class="btn-warning">Update Grade</button>
                </form>`;
            document.getElementById('edit_grd_student').value = data.student_id;
            document.getElementById('edit_grd_subject').value = data.subject_id;
            openModal();
        }

        function editAnnouncement(data) {
            document.getElementById('modalTitle').innerText = 'Edit Announcement';
            document.getElementById('modalBody').innerHTML = `
                <form method="POST">
                    <input type="hidden" name="action" value="update_announcement">
                    <input type="hidden" name="announcement_id" value="${data.announcement_id}">
                    <label>Title</label>
                    <input type="text" name="title" value="${data.title}" required>
                    <label>Message</label>
                    <textarea name="message" rows="4" required>${data.message}</textarea>
                    <button type="submit" class="btn-warning">Update Announcement</button>
                </form>`;
            openModal();
        }

        // Close modal if user clicks outside of modal content
        window.onclick = function(e) {
            const modal = document.getElementById('editModal');
            if (e.target === modal) closeModal();
        };
    </script>
</body>
</html>