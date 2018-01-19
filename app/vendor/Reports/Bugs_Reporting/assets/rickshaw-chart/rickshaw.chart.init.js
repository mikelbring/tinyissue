/**
* Theme: Velonic Admin Template
* Author: Coderthemes
* Module/App: RickshawChart Application
*/

!function($) {
    "use strict";

    var RickshawChart = function() {
        this.$body = $("body")
    };
    //creates area graph
    RickshawChart.prototype.createAreaGraph = function(selector, seriesData, random, colors, labels) {
      var areaGraph = new Rickshaw.Graph( {
          element: document.querySelector(selector),
          renderer: 'area',
          stroke: true,
          height: 250,
          preserve: true,
          series: [
            {
              color: colors[0],
              data: seriesData[0],
              name: labels[0]
            }, 
            {
              color: colors[1],
              data: seriesData[1],
              name: labels[1]
            }
          ]
      });
   
      areaGraph.render();
      
      setInterval( function() {
          random.removeData(seriesData);
          random.addData(seriesData);
          areaGraph.update();
      }, 700 );
      
      $(window).resize(function(){
          areaGraph.render();
      });

    },
    RickshawChart.prototype.createSimpleareaGraph = function(selector, simpleAdata,colors) {
        var Simplearea = new Rickshaw.Graph( {
            element: document.querySelector(selector),
            renderer: 'area',
            stroke: true,
            series: [ {
                    data: simpleAdata,
                    color: colors[0]
            },]  
        });
        Simplearea.render();
    },
    RickshawChart.prototype.createMultipleareaGraph = function(selector, multipleAdata1,multipleAdata2,colors) {
        var Multiplearea = new Rickshaw.Graph( {
            element: document.querySelector(selector),
            renderer: 'area',
            stroke: true,
            series: [ {
                data: multipleAdata1,
                color: colors[0],
                border: 0
        }, {    
                data: multipleAdata2,
                color: colors[1]
        }]    
        });
        Multiplearea.render();
    },
    RickshawChart.prototype.createLinetoggleGraph = function(selector, height, colors, names) {
      // set up our data series with 50 random data points

      var seriesData = [ [], [], [] ];
      var random = new Rickshaw.Fixtures.RandomData(150);

      for (var i = 0; i < 150; i++) {
        random.addData(seriesData);
      }

      // instantiate our graph!

      var graph = new Rickshaw.Graph( {
        element: document.getElementById(selector),
        height: height,
        renderer: 'line',
        series: [
          {
            color: colors[0],
            data: seriesData[0],
            name: names[0]
          }, {
            color: colors[1],
            data: seriesData[1],
            name: names[1]
          }, {
            color: colors[2],
            data: seriesData[2],
            name: names[2]
          }
        ]
      } );

      graph.render();

      var hoverDetail = new Rickshaw.Graph.HoverDetail( {
        graph: graph,
        formatter: function(series, x, y) {
          var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
          var swatch = '<span class="detail_swatch" style="background-color: #000' + series.color + '"></span>';
          var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
          return content;
        }
      } );
    },
    RickshawChart.prototype.createLinePlotGraph = function(selector, colors, names) {
      var graph = new Rickshaw.Graph( {
        element: document.getElementById(selector),
        renderer: 'lineplot',
        padding: { top: 0.1 },
        series: [
          {
            data: [ { x: 0, y: 40 }, { x: 1, y: 49 }, { x: 2, y: 38 }, { x: 3, y: 30 }, { x: 4, y: 32 } ],
            color: colors[0],
            name: names[0]
          }, {
            data: [ { x: 0, y: 19 }, { x: 1, y: 22 }, { x: 2, y: 32 }, { x: 3, y: 20 }, { x: 4, y: 21 } ],
            color: colors[1],
            name: names[1]
          }
        ]
      } );

      var hover = new Rickshaw.Graph.HoverDetail({ graph: graph });

      graph.render();
    },
    RickshawChart.prototype.createMultiGraph = function(selector, height, names, colors) {
      var seriesData = [ [], [], [], [], [] ];
      var random = new Rickshaw.Fixtures.RandomData(50);

      for (var i = 0; i < 75; i++) {
        random.addData(seriesData);
      }

      var graph = new Rickshaw.Graph( {
        element: document.getElementById(selector),
        renderer: 'multi',
        height: height,
        dotSize: 5,
        series: [
          {
            name: names[0],
            data: seriesData.shift(),
            color: colors[0],
            renderer: 'stack'
          }, {
            name: names[1],
            data: seriesData.shift(),
            color: colors[1],
            renderer: 'stack'
          }, {
            name: names[2],
            data: seriesData.shift(),
            color: colors[2],
            renderer: 'scatterplot'
          }, {
            name: names[3],
            data: seriesData.shift().map(function(d) { return { x: d.x, y: d.y / 4 } }),
            color: colors[3],
            renderer: 'bar'
          }, {
            name: names[4],
            data: seriesData.shift().map(function(d) { return { x: d.x, y: d.y * 1.5 } }),
            color: colors[4],
            renderer: 'line'
            
          }
        ]
      } );

      graph.render();

      var detail = new Rickshaw.Graph.HoverDetail({
        graph: graph
      });

      var legend = new Rickshaw.Graph.Legend({
        graph: graph,
        element: document.querySelector('#legend')
      });

      var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight({
          graph: graph,
          legend: legend,
          disabledColor: function() { return '#ddd' }
      });

      var highlighter = new Rickshaw.Graph.Behavior.Series.Toggle({
          graph: graph,
          legend: legend
      });
    },
    //initializing various charts and components
    RickshawChart.prototype.init = function() {
      //live statics
      var seriesData = [ [], [], [], [], [], [], [], [], [] ];
      var random = new Rickshaw.Fixtures.RandomData(200);

      for (var i = 0; i < 100; i++) {
          random.addData(seriesData);
      }

      //create live area graph
      var colors = ['#3bc0c3', '#E9E9E9'];
      var labels = ['Moscow', 'Shanghai'];
      this.createAreaGraph("#linechart", seriesData, random, colors, labels);

      //create Simple area graph
      var simpleAdata = [ 
                { x: 0, y: 20 }, 
                { x: 1, y: 25 }, 
                { x: 2, y: 38 }, 
                { x: 3, y: 28 }, 
                { x: 4, y: 20 } 
            ];
      var simpleAcolors = ['#3bc0c3'];
      this.createSimpleareaGraph("#simplearea", simpleAdata, simpleAcolors);

      //create Multiple area graph
      var multipleAdata1 = [ 
                { x: 0, y: 40 }, 
                    { x: 1, y: 49 }, 
                    { x: 2, y: 38 }, 
                    { x: 3, y: 30 }, 
                    { x: 4, y: 32 } 
            ];
        var multipleAdata2 = [ 
            { x: 0, y: 40 },
                    { x: 1, y: 49 },
                    { x: 2, y: 38 }, 
                    { x: 3, y: 30 }, 
                    { x: 4, y: 32 }  
        ];
      var MultipleAcolors = ['#3bc0c3','#E9E9E9'];
      this.createMultipleareaGraph("#multiplearea", multipleAdata1, multipleAdata2, MultipleAcolors);

      //create Line-Toggle graph
      var height = [250];
      var LineTcolors = ["#3bc0c3", "#f13c6e","#615ca8"];
      var names = ['New York', 'London','Tokyo'];
      this.createLinetoggleGraph("linetoggle", height, LineTcolors, names);

      //create Line-plot graph
      var LinePlotcolors = ['#f13c6e','#615ca8'];
      var linePnames = ["Series 1", "Series 2"];
      this.createLinePlotGraph("lineplotchart", LinePlotcolors, linePnames);

      //create Multi graph
      var Multiheight = [300];
      var multinames = ['Temperature', 'Heat index','Dewpoint','Pop','Humidity'];
      var multicolors = ['rgba(59, 192, 195, 0.6)','rgba(233, 233, 233, 0.6)','rgba(241, 60, 110, 0.6)','rgba(97, 92, 168, 0.6)','rgba(20, 8, 45, 0.6)'];
      this.createMultiGraph("multichart", Multiheight, multinames, multicolors);

    },

    //init dashboard
    $.RickshawChart = new RickshawChart, $.RickshawChart.Constructor = RickshawChart
    
}(window.jQuery),

//initializing dashboad2
function($) {
    "use strict";
    $.RickshawChart.init()
}(window.jQuery);







