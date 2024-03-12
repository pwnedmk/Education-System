document.addEventListener('DOMContentLoaded', function() {
    calendarInit();
});
function calendarInit() {
    var usaTimezone = 'America/Chicago'; 
    var today = new Date(new Date().toLocaleString('en-US', { timeZone: usaTimezone }));

    // Set the reference time for the calendar
    var thisMonth = today;

    // converted time (thisMonth) and today
    var currentYear = thisMonth.getFullYear();
    var currentMonth = thisMonth.getMonth();
    var currentDate = today.getDate();

    // Calendar rendering
    renderCalender(thisMonth);

    function renderCalender(thisMonth) {

        // Organizing Data for Rendering
        currentYear = thisMonth.getFullYear();
        currentMonth = thisMonth.getMonth();
        currentDate = thisMonth.getDate();

        // Find the date and day of the last day of the previous month
        var startDay = new Date(currentYear, currentMonth, 0);
        var prevDate = startDay.getDate();
        var prevDay = startDay.getDay();

        // Find the date and day of the month on the last day of the month
        var endDay = new Date(currentYear, currentMonth + 1, 0);
        var nextDate = endDay.getDate();
        var nextDay = endDay.getDay();

        // console.log(prevDate, prevDay, nextDate, nextDay);

        // Current month notation
        document.querySelector('.year-month').textContent = currentYear + '.' + (currentMonth + 1);

        // Creating a rendering html element
        var calendar = document.querySelector('.dates');
                calendar.innerHTML = '';
        
                // previeous month
                for (var i = prevDate - prevDay + 1; i <= prevDate; i++) {
                    calendar.innerHTML += '<div class="day prev disable">' + i + '</div>';
                }
                // this month
                for (var i = 1; i <= nextDate; i++) {
                    calendar.innerHTML += '<div class="day current">' + i + '</div>';
                }
                // next month
                for (var i = 1; i <= (7 - nextDay == 7 ? 0 : 7 - nextDay); i++) {
                    calendar.innerHTML += '<div class="day next disable">' + i + '</div>';
                }

        // Indicate today's date
        if (today.getMonth() == currentMonth) {
            var currentMonthDate = document.querySelectorAll('.dates .current');
            currentMonthDate[currentDate - 1].classList.add('today');
        }
    
    }

    // go prev
    document.querySelector('.go-prev').addEventListener('click', function() {
        thisMonth = new Date(currentYear, currentMonth - 1, 1);
        renderCalender(thisMonth);
    });

    // go next
    document.querySelector('.go-next').addEventListener('click', function() {
        thisMonth = new Date(currentYear, currentMonth + 1, 1);
        renderCalender(thisMonth); 
    });
}