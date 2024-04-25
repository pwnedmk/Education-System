document.addEventListener('DOMContentLoaded', function () {
    fetch('adminData.php')
    .then(response => response.json())
    .then(grades => {
        const labels = Object.keys(grades);
        const values = Object.values(grades);

        createChart(labels, values);
    })
    .catch(error => console.error('Error fetching data:', error));
});

function createChart(labels, data) {
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['green', 'lime', 'yellow', 'orange', 'red'] // Colors for A, B, C, D, Failing
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                }
            }
        }
    });
}