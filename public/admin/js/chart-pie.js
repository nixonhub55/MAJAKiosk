 
try {
   

var ctx = document.getElementById("myPieChartLeave"); 
var pieData = [
    leaveChartData.approve || 0,
    leaveChartData.decline || 0,
    leaveChartData.pending || 0,
    leaveChartData.cancel || 0
];
 
var labels = ["Approved", "Declined", "Pending", "Cancelled"];

// var totalPieData = pieData.reduce((total, num) => total + num, 0);

var totalPieData = pieData.reduce((total, num) => total + num, 0);

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: labels.map((label, index) => {
      let percentage = ((pieData[index] / totalPieData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: pieData,
      backgroundColor: ['#2F4F4F', '#A9A9A9', '#4682B4', '#708090', '#5F9EA0'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalPieData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500,
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});



var ctxOfficialBusiness = document.getElementById("myPieChartOfficialBusiness");
var ctxOfficialBusinessData = [
  obChartData.approve || 0,
  obChartData.decline || 0,
  obChartData.pending || 0,
  obChartData.cancel || 0
];
var totalctxOfficialBusinessData = ctxOfficialBusinessData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(ctxOfficialBusiness, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((ctxOfficialBusinessData[index] / totalctxOfficialBusinessData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: ctxOfficialBusinessData,
      backgroundColor: ['#87CEFA', '#98FB98', '#FFDAB9', '#E6E6FA', '#FFFACD'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right', 
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalctxOfficialBusinessData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalctxOfficialBusinessData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500,
      easing: "easeInOutQuad",
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});



var myPieChartOffset = document.getElementById("myPieChartOffset");
var myPieChartOffsetData = [
  offsetChartData.approve || 0,
  offsetChartData.decline || 0,
  offsetChartData.pending || 0,
  offsetChartData.cancel || 0
];
var totalMyPieChartOffsetData = myPieChartOffsetData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartOffset, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((myPieChartOffsetData[index] / totalMyPieChartOffsetData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartOffsetData,
      backgroundColor: ['#003f5c', '#2f4b7c', '#665191', '#a05195', '#d45087'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalMyPieChartOffsetData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});






var myPieChartOvertime = document.getElementById("myPieChartOvertime");
var myPieChartOvertimeData = [
  overtimeChartData.approve || 0,
  overtimeChartData.decline || 0,
  overtimeChartData.pending || 0,
  overtimeChartData.cancel || 0
];
var totalMyPieChartOvertimeData = myPieChartOvertimeData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartOvertime, {
  type: 'pie',
  data: {
    labels: labels.map((label, index) => {
      let percentage = ((myPieChartOvertimeData[index] / totalMyPieChartOvertimeData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartOvertimeData,
      backgroundColor: ['#34495e', '#1abc9c', '#ecf0f1', '#3498db', '#95a5a6'], 
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalMyPieChartOvertimeData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});


var myPieChartTimeAdjustment = document.getElementById("myPieChartTimeAdjustment");
var myPieChartTimeAdjustmentData = [
  timeAdjustmentChartData.approve || 0,
  timeAdjustmentChartData.decline || 0,
  timeAdjustmentChartData.pending || 0,
  timeAdjustmentChartData.cancel || 0
];
var totalMyPieChartTimeAdjustmentData = myPieChartTimeAdjustmentData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartTimeAdjustment, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((myPieChartTimeAdjustmentData[index] / totalMyPieChartTimeAdjustmentData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartTimeAdjustmentData,
      backgroundColor: ['#98FB98', '#FFDAB9', '#E6E6FA', '#87CEFA', '#FFFACD'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalMyPieChartTimeAdjustmentData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});



var myPieChartTimeEntry = document.getElementById("myPieChartTimeEntry");

var myPieChartTimeEntryData = [
  timeentryChartData.approve || 0,
  timeentryChartData.decline || 0,
  timeentryChartData.pending || 0,
  timeentryChartData.cancel || 0
];
var totalmyPieChartTimeEntryData = myPieChartTimeEntryData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartTimeEntry, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((myPieChartTimeEntryData[index] / totalmyPieChartTimeEntryData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartTimeEntryData,  
      backgroundColor: ['#2F4F4F', '#A9A9A9', '#4682B4', '#708090', '#5F9EA0'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalmyPieChartTimeEntryData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});

 

var myPieChartScheduleChange = document.getElementById("myPieChartScheduleChange"); 
var myPieChartScheduleChangeData = [
  ScheduleChangeChartData.approve || 0,
  ScheduleChangeChartData.decline || 0,
  ScheduleChangeChartData.pending || 0,
  ScheduleChangeChartData.cancel || 0
];
var totalmyPieChartScheduleChangeData = myPieChartScheduleChangeData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartScheduleChange, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((myPieChartScheduleChangeData[index] / totalmyPieChartScheduleChangeData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartScheduleChangeData,
      backgroundColor: ['#34495e', '#1abc9c', '#ecf0f1', '#3498db', '#95a5a6'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalmyPieChartScheduleChangeData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});




var myPieChartHRDCertificate = document.getElementById("myPieChartHRDCertificate"); 
var myPieChartHRDCertificateData = [
  HRDCertificateChartData.approve || 0,
  HRDCertificateChartData.decline || 0,
  HRDCertificateChartData.pending || 0,
  HRDCertificateChartData.cancel || 0
];
var totalmyPieChartHRDCertificateData = myPieChartHRDCertificateData.reduce((total, num) => total + num, 0);
var myPieChart = new Chart(myPieChartHRDCertificate, {
  type: 'pie',
  data: {
    labels: ["Approved", "Denied", "Pending", "Cancelled"].map((label, index) => {
      let percentage = ((myPieChartHRDCertificateData[index] / totalmyPieChartHRDCertificateData) * 100).toFixed(2);
      return `${label} (${percentage}%)`;
    }),
    datasets: [{
      data: myPieChartHRDCertificateData,
      backgroundColor: ['#2F4F4F', '#A9A9A9', '#4682B4', '#708090', '#5F9EA0'],
      hoverBackgroundColor: ['#388E3C', '#D32F2F', '#FFA000', '#1976D2'],
      borderColor: "#fff",
      borderWidth: 2,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          color: "#333",
          font: {
            size: 16,
            weight: "bold"
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let value = context.raw;
            let percentage = ((value / totalmyPieChartHRDCertificateData) * 100).toFixed(2);
            return `${context.label}: ${value} (${percentage}%)`;
          }
        },
        backgroundColor: "#333",
        titleFont: { size: 14 },
        bodyFont: { size: 12 },
        borderColor: "#fff",
        borderWidth: 1,
      },
      datalabels: {
        color: '#fff',
        formatter: (value, ctx) => {
          let percentage = ((value / totalPieData) * 100).toFixed(1);
          return `${percentage}%`;
        },
        font: {
          weight: 'bold',
          size: 14
        }
      }
    },
    animation: {
      duration: 1500, 
      easing: "easeInOutQuad", 
    },
    layout: {
      padding: {
        top: 20,
        bottom: 20
      }
    }
  },
});


} catch (error) {
  
}