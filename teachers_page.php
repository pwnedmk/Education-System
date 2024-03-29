<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <script src="javascript.js"></script>
    <link rel="stylesheet" type="text/css" href="test2.css">
</head>
<body>
    <nav id="menu_area">
        <ul>
            <li><a href="teachers_page.php">Home</a></li>
            <li>Student List</li>
            <li><a href="upload_assignment.php">Create Assignment</a></li>
            <li>Grade Assignment</li>
            <li>Calendar</li>
        </ul>
    </nav>
    <div id="content_area">
        <div id="list">
            <ul>
                <li>.</li>
                <li>student list with assignment</li>
                <li></li>
            </ul>
        </div>
        <hr>
        <div id="horizontal_section">
            <div class="col" id="top_performer">
                <ul>
                    <li>.</li>
                    <li>top performer</li>
                    <li>.</li>
                </ul>
            </div>
            <div class="col2" id="none">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="col3" id="calendar">
                <div class="sec_cal">
                    <div class="cal_nav">
                        <a href="javascript:;" class="nav-btn go-prev">prev</a>
                        <div class="year-month"></div>
                        <a href="javascript:;" class="nav-btn go-next">next</a>
                    </div>
                    <div class="cal_wrap">
                        <div class="days">
                            <div class="day">MON</div>
                            <div class="day">TUE</div>
                            <div class="day">WED</div>
                            <div class="day">THU</div>
                            <div class="day">FRI</div>
                            <div class="day">SAT</div>
                            <div class="day">SUN</div>
                        </div>
                        <div class="dates"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>