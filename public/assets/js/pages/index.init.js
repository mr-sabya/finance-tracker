document.addEventListener("wire:navigated", function () {
    new Morris.Area({
        element: "morris-area-example",
        pointSize: 3,
        lineWidth: 1,
        data: [{
            y: "2009",
            a: 10,
            b: 20
        }, {
            y: "2010",
            a: 75,
            b: 65
        }, {
            y: "2011",
            a: 50,
            b: 40
        }, {
            y: "2012",
            a: 75,
            b: 65
        }, {
            y: "2013",
            a: 50,
            b: 40
        }, {
            y: "2014",
            a: 75,
            b: 65
        }, {
            y: "2015",
            a: 90,
            b: 60
        }, {
            y: "2016",
            a: 90,
            b: 75
        }],
        xkey: "y",
        ykeys: ["a", "b"],
        labels: ["Series A", "Series B"],
        resize: !0,
        gridLineColor: "rgba(108, 120, 151, 0.1)",
        hideHover: "auto",
        lineColors: ["#00a3ff", "#04a2b3"]
    }), new Morris.Bar({
        element: "morris-bar-example",
        data: [{
            y: "2009",
            a: 100,
            b: 90
        }, {
            y: "2010",
            a: 75,
            b: 65
        }, {
            y: "2011",
            a: 50,
            b: 40
        }, {
            y: "2012",
            a: 75,
            b: 65
        }, {
            y: "2013",
            a: 50,
            b: 40
        }, {
            y: "2014",
            a: 75,
            b: 65
        }, {
            y: "2015",
            a: 100,
            b: 90
        }, {
            y: "2016",
            a: 90,
            b: 75
        }],
        xkey: "y",
        ykeys: ["a", "b"],
        labels: ["Series A", "Series B"],
        gridLineColor: "rgba(108, 120, 151, 0.1)",
        barSizeRatio: .4,
        resize: !0,
        hideHover: "auto",
        barColors: ["#04a2b3", "#00a3ff"]
    }), new Morris.Donut({
        element: "morris-donut-example",
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: !0,
        colors: ["#dcdcdc", "#e66060", "#04a2b3"],
        gridLineColor: "rgba(108, 120, 151, 0.1)",
        labelColor: "#fff"
    })
});