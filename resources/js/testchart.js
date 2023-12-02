/*
 *  Project    : https://tailkit.com
 *  Author     : pixelcave
 *  Description: JS functionality for App - 01 CRM Template
 */

// Chart.js, for more examples you can check out http://www.chartjs.org/docs
import Chart from "chart.js/auto";

export default class CRM {
    constructor() {
        this.initCharts();
    }

    /*
     * Init Charts
     *
     */
    initCharts() {
        // Chart Containers
        let chartDashboardSalesCon = document.getElementById(
            "js-01crm-chartjs-sales",
        );
        let chartDashboardEarningsCon = document.getElementById(
            "js-01crm-chartjs-earnings",
        );

        if (chartDashboardSalesCon && chartDashboardEarningsCon) {
            // Set Global Chart.js configuration
            Chart.defaults.color = "#9CA3AF";
            Chart.defaults.scale.grid.color = "transparent";
            Chart.defaults.scale.grid.zeroLineColor = "transparent";
            Chart.defaults.scale.beginAtZero = true;
            Chart.defaults.plugins.tooltip.radius = 3;
            Chart.defaults.plugins.legend.display = false;

            // Chart Variables
            let chartDashboardSales, chartDashboardEarnings;

            // Lines Charts Data
            let chartDashboardSalesData = {
                labels: ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
                datasets: [
                    {
                        label: "This Week",
                        fill: true,
                        backgroundColor: "rgba(168, 85, 247, .75)",
                        borderColor: "rgba(168, 85, 247, 1)",
                        pointBackgroundColor: "rgba(168, 85, 247, 1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(168, 85, 247, 1)",
                        data: [5, 10, 8, 6, 7, 9, 8],
                    },
                ],
            };

            let chartDashboardSalesOptions = {
                maintainAspectRatio: false,
                tension: 0.4,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 14,
                    },
                },
                interaction: {
                    intersect: false,
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return " " + context.parsed.y + " Sales";
                            },
                        },
                    },
                },
            };

            let chartDashboardEarningsData = {
                labels: ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
                datasets: [
                    {
                        label: "This Week",
                        fill: true,
                        backgroundColor: "rgba(16, 185, 129, .75)",
                        borderColor: "rgba(16, 185, 129, 1)",
                        pointBackgroundColor: "rgba(16, 185, 129, 1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(16, 185, 129, 1)",
                        data: [105, 160, 112, 125, 162, 269, 231],
                    },
                ],
            };

            let chartDashboardEarningsOptions = {
                maintainAspectRatio: false,
                tension: 0.4,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 280,
                    },
                },
                interaction: {
                    intersect: false,
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return " $" + context.parsed.y;
                            },
                        },
                    },
                },
            };

            // Init Charts
            if (chartDashboardSalesCon !== null) {
                chartDashboardSales = new Chart(chartDashboardSalesCon, {
                    type: "line",
                    data: chartDashboardSalesData,
                    options: chartDashboardSalesOptions,
                });
            }

            if (chartDashboardEarningsCon !== null) {
                chartDashboardEarnings = new Chart(chartDashboardEarningsCon, {
                    type: "line",
                    data: chartDashboardEarningsData,
                    options: chartDashboardEarningsOptions,
                });
            }
        }
    }
}
