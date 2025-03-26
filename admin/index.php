<?php 
require_once "../connection.php";

if(!isset($_SESSION['user']) || $_SESSION['is_login'] !=true){
  header("Location: ../login");
  exit();
}

$page=$_GET['uri'] ?? 'dashboard';
$page = str_replace('.php','',$page);
$page = $page.'.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <style>
    :root {
      --sidebar-width: 250px;
      --topbar-height: 60px;
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --info-color: #4895ef;
      --warning-color: #f72585;
      --light-color: #f8f9fa;
      --dark-color: #212529;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fb;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background-color: var(--dark-color);
      color: white;
      transition: all 0.3s;
      z-index: 1000;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
      padding: 15px;
      background-color: rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.8);
      padding: 12px 20px;
      transition: all 0.3s;
    }

    .sidebar .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .sidebar .nav-link.active {
      background-color: var(--primary-color);
      color: white;
    }

    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    /* Main Content */
    .main-content {
      margin-left: var(--sidebar-width);
      transition: all 0.3s;
    }

    /* Topbar */
    .topbar {
      height: var(--topbar-height);
      background-color: white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 900;
    }

    .search-bar {
      max-width: 400px;
    }

    /* Dashboard Cards */
    .dashboard-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .card-icon {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    /* Charts */
    .chart-container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      padding: 20px;
      margin-bottom: 20px;
    }

    /* Table */
    .table-container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      padding: 20px;
      margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        margin-left: calc(var(--sidebar-width) * -1);
      }

      .sidebar.show {
        margin-left: 0;
      }

      .main-content {
        margin-left: 0;
      }

      .main-content.pushed {
        margin-left: var(--sidebar-width);
      }
    }

    /* Progress bars */
    .progress {
      height: 8px;
      margin-top: 8px;
    }

    /* User profile */
    .user-profile {
      display: flex;
      align-items: center;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    /* Notifications */
    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      font-size: 10px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background-color: var(--warning-color);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <h4 class="mb-0">Dashboard</h4>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="<?=url('admin');?>">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=url('admin/users');?>">
          <i class="bi bi-graph-up"></i> Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=url('admin/logout.php');?>">
          <i class="bi bi-graph-up"></i> Logout
        </a>
      </li>
      
    
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="main-content">
    <!-- Topbar -->
    <div class="topbar px-4 d-flex align-items-center justify-content-between">
      <button class="btn d-lg-none" id="sidebar-toggle">
        <i class="bi bi-list fs-4"></i>
      </button>
      <div class="search-bar d-none d-md-block">
        <div class="input-group">
          <span class="input-group-text bg-light border-0">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" class="form-control border-0 bg-light" placeholder="Search...">
        </div>
      </div>
      <div class="d-flex align-items-center">
        <div class="user-profile">
          <img src="" alt="" class="user-avatar">
          <div class="d-none d-md-block">
            <div class="fw-bold">
              <?=$_SESSION['user']['name'];?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-12">
            <?php 
                    $pagePath="./pages/$page";
                    if(file_exists($pagePath) && is_file($pagePath)){
                        require $pagePath;
                    }else{
                        echo "404 Page not found";
                    }
                ?>
            </div>
        </div>
    
    </div>

    <!-- Footer -->
    <footer class="bg-white p-3 text-center">
      <p class="mb-0 text-muted">© 2023 Admin Dashboard. All rights reserved.</p>
    </footer>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JS -->
  <script>
    // Toggle sidebar on mobile
    document.getElementById('sidebar-toggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('show');
      document.getElementById('main-content').classList.toggle('pushed');
    });
  </script>
</body>
</html>