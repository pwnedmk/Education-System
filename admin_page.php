<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="test4.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav id="menu_area">
    <ul>
        <li><a href="admin_page.php">Home</a></li>
        <li><a href="studentlist1.php">Student List</a></li>
        <li><a href="teacherlist.php">Teacher List</a></li>
        <li><a href="createNewuser.php">Create New User</a></li>
        <li><a href="logout.php"><button>Logout</button></a></li>
    </ul>
</nav>
<div id="chart">
    <h3>Overall Grade for Student</h3>
    <canvas id="myPieChart"></canvas>
    <script src="assignments_chart.js"></script>
</div>
</body>
</html>
