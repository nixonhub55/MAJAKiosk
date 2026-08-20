
 
var ctx = document.getElementById("myBarChart");
var applicationsData = [
  approvalsBarData.otForms || 0,
  approvalsBarData.osForms || 0,
  approvalsBarData.laForms || 0,
  approvalsBarData.taForms || 0,
  approvalsBarData.obForms || 0
];
var totalApplications = applicationsData.reduce((total, num) => total + num, 0);

var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Overtime", "Offset", "Leave", "Time Adjustment", "Official Business"]
      .map((label, index) => {
        let value = applicationsData[index];
        let percentage = ((value / totalApplications) * 100).toFixed(2);
        return `${label} ${value}(${percentage}%)`;
      }),
    datasets: [{
      label: "Applications",
      data: applicationsData,
      backgroundColor: [
        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40", "#FF6384", "#4BC0C0"
      ],
      borderColor: [
        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40", "#FF6384", "#4BC0C0"
      ],
      borderWidth: 2,
      borderRadius: 10, // Rounded corners
      hoverBackgroundColor: "#000",
      hoverBorderColor: "#fff",
      hoverBorderWidth: 3,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        labels: {
          fontColor: "#333",
          fontSize: 14
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalApplications) * 100).toFixed(2);
            return `Value: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#000",
        titleFont: { size: 16 },
        bodyFont: { size: 14 },
        borderColor: "#fff",
        borderWidth: 1,
      }
    },
    scales: {
      x: {
        ticks: {
          color: "#666",
          font: {
            size: 12
          }
        },
        grid: {
          display: false
        }
      },
      y: {
        ticks: {
          color: "#666",
          font: {
            size: 12
          },
          stepSize: 2000,
          beginAtZero: true
        },
        grid: {
          color: "rgba(0,0,0,0.1)"
        }
      }
    },
    layout: {
      padding: {
        top: 20,
        left: 10,
        right: 10,
        bottom: 10
      }
    },
    animation: {
      duration: 2000, 
      easing: "easeInOutQuad", 
    }
  }
}); 