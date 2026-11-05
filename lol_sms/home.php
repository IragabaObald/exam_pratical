<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Management System - Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background-color: #f8f9fa;
    }
    .sidebar {
      min-height: calc(100vh - 56px);
      background-color: #2c3e50;
    }
    .sidebar .nav-link {
      color: #ecf0f1;
      padding: 0.75rem 1.25rem;
      border-radius: 0.375rem;
      margin-bottom: 0.2rem;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: #34495e;
      color: #fff;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
    }
    .stat-card {
      border: none;
      border-left: 4px solid;
      transition: transform 0.2s;
    }
    .stat-card:hover {
      transform: translateY(-3px);
    }
  </style>
</head>
<body>
    <?php
              session_start();

              ?>

  <!-- Top Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">
        <i class="bi bi-mortarboard-fill me-2"></i>O.SMS
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="topNavbar">
        <ul class="navbar-row navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item me-3">
            <a class="nav-link text-white position-relative" href="#">
              
            
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle fs-4 me-2"></i><h3><?php echo $_SESSION['username'];?></h3>
            

            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Container -->
  <div class="container-fluid">
    <div class="row">
      
      <!-- Sidebar Navigation -->
      <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="student.php">
              <i class="bi bi-person-badge"></i> Student Portal
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="class.php">
              <i class="bi bi-door-open"></i> Classes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="subject.php">
              <i class="bi bi-book"></i> Subjects
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="grades.php">
              <i class="bi bi-journal-check"></i> Grades
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attendance.php">
              <i class="bi bi-calendar-check"></i> Attendance
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="announcements.php">
              <i class="bi bi-megaphone"></i> Announcements
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">LOGOUT  
            </a>
          </li>
        </ul>
      </nav>

      <!-- Main Content Area -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        
        <!-- Page Title & Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
          <h1 class="h2">School Dashboard</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <span class="badge bg-primary fs-6 px-3 py-2">Academic Year: 2026-2027</span>
          </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm stat-card border-primary h-100">