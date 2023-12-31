$(function () {
    "use strict";
    var e = {
        series: [
            { name: "Online Revenue", data: [1, 40, 18, 51, 22, 109, 0] },
            { name: "Offline Revenue", data: [1, 20, 55, 12, 84, 22, 4] },
        ],
        chart: { height: 350, type: "area" },
        colors: ["#5066e0", "#00d48f"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth" },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            yAxisIndex: 0,
        },
        yaxis: {
            labels: {
                formatter: function (e, r) {
                    return Math.round(e);
                },
            },
        },
        grid: {
            show: !0,
            borderColor: "rgba(224, 227, 247, 0.5)",
            strokeDashArray: 0,
        },
        legend: { show: !1 },
        markers: { size: 0, style: "hollow" },
    };
    new ApexCharts(document.querySelector("#chart"), e).render();
    var r = {
        series: [76, 67, 61, 90],
        chart: { height: 350, type: "radialBar" },
        plotOptions: {
            radialBar: {
                offsetY: 0,
                startAngle: -120,
                endAngle: 120,
                hollow: {
                    margin: 10,
                    size: "50%",
                    background: "transparent",
                    image: void 0,
                },
                track: {
                    show: !0,
                    startAngle: void 0,
                    endAngle: void 0,
                    background: "#dce0f8",
                    strokeWidth: "50%",
                    opacity: 1,
                    margin: 5,
                },
                dataLabels: { name: { show: !1 }, value: { show: !1 } },
            },
        },
        stroke: { lineCap: "round" },
        colors: ["#5066e0", "#00d48f", "#ff8c00", "#2d97ff"],
        labels: ["Travel", "Presentation", "Business", "Others"],
        legend: {
            show: !1,
            floating: !0,
            fontSize: "16px",
            position: "left",
            offsetX: 10,
            offsetY: 15,
            labels: { useSeriesColors: !0 },
            markers: { size: 0 },
            itemMargin: { vertical: 3 },
        },
        responsive: [{ breakpoint: 480, options2: { legend: { show: !1 } } }],
    };
    new ApexCharts(document.querySelector("#chart2"), r).render();
});
