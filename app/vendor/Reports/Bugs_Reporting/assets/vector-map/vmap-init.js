
/**
* Theme: Velonic Admin Template
* Author: Coderthemes
* VectorMap
*/

!function($) {
    "use strict";

    var VectorMap = function() {};

    VectorMap.prototype.init = function() {
        //various examples

        $('#world-vmap').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#444444',
            enableZoom: true,
            borderWidth:1,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#1a2942', '#3bc0c3'],
            normalizeFunction: 'polynomial'
        });
        $('#europe-vmap').vectorMap({
            map: 'europe_en',
            backgroundColor: null,
            color: '#ffffff',
            borderWidth:1,
            hoverOpacity: 0.7,
            selectedColor: '#444444',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#1a2942', '#3bc0c3'],
            normalizeFunction: 'polynomial'
        });
 




        $('#asia-vmap').vectorMap({
            map: 'asia_en',
            backgroundColor: null,
            color: '#ffffff',
            borderWidth:1,
            hoverOpacity: 0.7,
            selectedColor: '#444444',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#1a2942', '#3bc0c3'],
            normalizeFunction: 'polynomial'
        });



        $('#australia-vmap').vectorMap({
            map: 'australia_en',
            backgroundColor: null,
            color: '#ffffff',
            borderWidth:1,
            hoverOpacity: 0.7,
            selectedColor: '#444444',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#1a2942', '#3bc0c3'],
            normalizeFunction: 'polynomial'
        });


        $('#vmap-usa').vectorMap({
            map: 'usa_en',
            backgroundColor: null,
            color: '#ffffff',
            borderWidth:1,
            hoverOpacity: 0.7,
            selectedColor: '#444444',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#1a2942', '#3bc0c3'],
            normalizeFunction: 'polynomial'
        });
    },
    //init
    $.VectorMap = new VectorMap, $.VectorMap.Constructor = VectorMap
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.VectorMap.init()
}(window.jQuery);