
/**
* Theme: Velonic Admin Template
* Author: Coderthemes
* Chart Js Page
*/

!function($) {
    "use strict";

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function respChart(selector,type,data, options) {
        // get selector by context
        var ctx = selector.get(0).getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                    new Chart(ctx).Line(data, options);
                    break;
                case 'Doughnut':
                    new Chart(ctx).Doughnut(data, options);
                    break;
                case 'Pie':
                    new Chart(ctx).Pie(data, options);
                    break;
                case 'Bar':
                    new Chart(ctx).Bar(data, options);
                    break;
                case 'Radar':
                    new Chart(ctx).Radar(data, options);
                    break;
                case 'PolarArea':
                    new Chart(ctx).PolarArea(data, options);
                    break;
            }
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJs.prototype.init = function() {
        //creating lineChart
        var data = {
            labels : ["January","February","March","April","May","June","July"],
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.4)",
                    strokeColor : "rgba(220,220,220,0.4)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    data : [33,52,63,92,50,53,46]
                },
                {
                    fillColor : "rgba(59,192,195,0.4)",
                    strokeColor : "rgba(59,192,195,0.4)",
                    pointColor : "rgba(59,192,195,1)",
                    pointStrokeColor : "#fff",
                    data : [22,20,30,60,29,25,12]
                },
                {
                    fillColor : "rgba(97, 92, 168, 0.4)",
                    strokeColor : "rgba(97, 92, 168, 0.4)",
                    pointColor : "rgba(97, 92, 168, 0.4)",
                    pointStrokeColor : "#fff",
                    data : [14,16,12,5,32,9,33]
                }

            ]
        };
        
        this.respChart($("#lineChart"),'Line',data);

        //donut chart
        var data1 = [
            {
                        value: 30,
                        color:"#E67A77"
                    },
                    {
                        value : 50,
                        color : "#D9DD81"
                    },
                    {
                        value : 100,
                        color : "#79D1CF"
                    },
                    {
                        value : 40,
                        color : "#95D7BB"
                    },
                    {
                        value : 120,
                        color : "#4D5360"
                    }

        ]
        this.respChart($("#doughnut"),'Doughnut',data1);


        //Pie chart
        var data2 = [
            {
                value: 40,
                color:"#dcdcdc"
            },
            {
                value : 80,
                color : "#3bc0c3"
            },
            {
                value : 70,
                color : "#1a2942"
            }
        ]
        this.respChart($("#pie"),'Pie',data2);


        //barchart
        var data3 = {
            labels : ["January","February","March","April","May","June","July"],
                    datasets : [
                        {
                            fillColor : "#1a2942",
                            strokeColor : "#1a2942",
                            data : [65,59,90,81,56,55,40]
                        },
                        {
                            fillColor : "#3bc0c3",
                            strokeColor : "#3bc0c3",
                            data : [28,48,40,19,96,27,100]
                        }
                    ]
        }
        this.respChart($("#bar"),'Bar',data3);

        //radar chart
        var data4 = {
            labels : ["Eating","Drinking","Sleeping","Designing","Coding","Partying","Running"],
            datasets : [
                {
                    fillColor : "rgba(59,192,195,0.5)",
                    strokeColor : "rgba(59,192,195,0.9)",
                    pointColor : "rgba(59,192,195,1)",
                    pointStrokeColor : "#fff",
                    data : [65,59,90,81,56,55,40]
                },
                {
                    fillColor : "rgba(26,41,66,0.5)",
                    strokeColor : "rgba(26,41,66,0.8)",
                    pointColor : "rgba(26,41,66,1)",
                    pointStrokeColor : "#fff",
                    data : [28,48,40,19,96,27,100]
                }
            ]
        }
        this.respChart($("#radar"),'Radar',data4);

        //Polar area chart
        var data5 = [
            {
                value : 30,
                color: "#ebc142"
            },
            {
                value : 90,
                color: "#3bc0c3"
            },
            {
                value : 24,
                color: "#1a2942"
            },
            {
                value : 58,
                color: "#f13c6e"
            },
            {
                value : 82,
                color: "#615ca8"
            },
            {
                value : 8,
                color: "#1ca8dd"
            }
        ]
        this.respChart($("#polarArea"),'PolarArea',data5);
    },
    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.ChartJs.init()
}(window.jQuery);