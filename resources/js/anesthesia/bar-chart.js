
var barChartData10 = [];
barChartData10.push({
   value: 0,
   indicator: 'point',
   shape: 'triangle',
   width: 18,
   height: 16,
   offset: 8,
   color: '#1b02f7',
   colorRanges: [{
      startpoint: 0,
      breakpoint: 1,
      color: '#1b02f7'
   }, {
      startpoint: 1,
      breakpoint: 3,
      color: '#47fe12'
   }, {
      startpoint: 3,
      breakpoint: 7,
      color: '#e1e10d'
   }, {
      startpoint: 7,
      breakpoint: 10,
      color: '#fe1229'
   }],
   tooltipRanges: [{
      startpoint: 1,
      breakpoint: 4,
      tooltip: 'Low'
   }, {
      startpoint: 4,
      breakpoint: 7,
      tooltip: 'Moderate'
   }, {
      startpoint: 7,
      breakpoint: 10,
      tooltip: 'High'
   }]
});
var ctx10 = document.getElementById("canvas10").getContext("2d");
window.myBar10 = new Chart(ctx10).Linear(barChartData10, {
   range: {
      startValue: 0,
      endValue: 10
   },
   responsive: true,
   animationSteps: 90,
   axisColor: '#c5c7cf',
   axisWidth: 6,
   majorTicks: {
      interval: 1,
      width: 8,
      height: 1,
      offset: 1,
      color: '#000'
   },
   minorTicks: {
      interval: 5,
      width: 3,
      height: 1,
      offset: 0,
      color: '#000'
   },
   tickLabels: {
      interval: 1,
      units: '',
      offset: -17
   },
   geometry: 'horizontal',
   scaleColorRanges: [{
      start: 0,
      end: 1,
      color: '#1b02f7'
   }, {
      start: 1,
      end: 3,
      color: '#47fe12'
   }, {
      start: 3,
      end: 7,
      color: '#e1e10d'
   }, {
      start: 7,
      end: 10,
      color: '#fe1229'
   }],
});





var barChartData10 = [];
$(document).ready(function () {


   $("#vasinput").on("keyup", function () {

      var vasscore = $("#vasinput").val() || 0;
      barChartData10.pop();
      barChartData10.push({
         value: vasscore,
         indicator: 'point',
         shape: 'triangle',
         width: 18,
         height: 16,
         offset: 8,
         color: '#1b02f7',
         colorRanges: [{
            startpoint: 0,
            breakpoint: 1,
            color: '#1b02f7'
         }, {
            startpoint: 1,
            breakpoint: 3,
            color: '#47fe12'
         }, {
            startpoint: 3,
            breakpoint: 7,
            color: '#e1e10d'
         }, {
            startpoint: 7,
            breakpoint: 10,
            color: '#fe1229'
         }],
         tooltipRanges: [{
            startpoint: 1,
            breakpoint: 4,
            tooltip: 'Low'
         }, {
            startpoint: 4,
            breakpoint: 7,
            tooltip: 'Moderate'
         }, {
            startpoint: 7,
            breakpoint: 10,
            tooltip: 'High'
         }]
      });

      var ctx10 = document.getElementById("canvas10").getContext("2d");
      window.myBar10 = new Chart(ctx10).Linear(barChartData10, {
         range: {
            startValue: 0,
            endValue: 10
         },
         responsive: true,
         animationSteps: 90,
         axisColor: '#c5c7cf',
         axisWidth: 6,
         majorTicks: {
            interval: 1,
            width: 8,
            height: 1,
            offset: 1,
            color: '#000'
         },
         minorTicks: {
            interval: 5,
            width: 3,
            height: 1,
            offset: 0,
            color: '#000'
         },
         tickLabels: {
            interval: 1,
            units: '',
            offset: -17
         },
         geometry: 'horizontal',
         scaleColorRanges: [{
            start: 0,
            end: 1,
            color: '#1b02f7'
         }, {
            start: 1,
            end: 3,
            color: '#47fe12'
         }, {
            start: 3,
            end: 7,
            color: '#e1e10d'
         }, {
            start: 7,
            end: 10,
            color: '#fe1229'
         }],
      });
   });


   setTimeout(function( ) {
      var vasscore = $("#vasinput").val() || 0;
      barChartData10.pop();
      barChartData10.push({
         value: vasscore,
         indicator: 'point',
         shape: 'triangle',
         width: 18,
         height: 16,
         offset: 8,
         color: '#1b02f7',
         colorRanges: [{
            startpoint: 0,
            breakpoint: 1,
            color: '#1b02f7'
         }, {
            startpoint: 1,
            breakpoint: 3,
            color: '#47fe12'
         }, {
            startpoint: 3,
            breakpoint: 7,
            color: '#e1e10d'
         }, {
            startpoint: 7,
            breakpoint: 10,
            color: '#fe1229'
         }],
         tooltipRanges: [{
            startpoint: 1,
            breakpoint: 4,
            tooltip: 'Low'
         }, {
            startpoint: 4,
            breakpoint: 7,
            tooltip: 'Moderate'
         }, {
            startpoint: 7,
            breakpoint: 10,
            tooltip: 'High'
         }]
      });

      var ctx10 = document.getElementById("canvas10").getContext("2d");
      window.myBar10 = new Chart(ctx10).Linear(barChartData10, {
         range: {
            startValue: 0,
            endValue: 10
         },
         responsive: true,
         animationSteps: 90,
         axisColor: '#c5c7cf',
         axisWidth: 6,
         majorTicks: {
            interval: 1,
            width: 8,
            height: 1,
            offset: 1,
            color: '#000'
         },
         minorTicks: {
            interval: 5,
            width: 3,
            height: 1,
            offset: 0,
            color: '#000'
         },
         tickLabels: {
            interval: 1,
            units: '',
            offset: -17
         },
         geometry: 'horizontal',
         scaleColorRanges: [{
            start: 0,
            end: 1,
            color: '#1b02f7'
         }, {
            start: 1,
            end: 3,
            color: '#47fe12'
         }, {
            start: 3,
            end: 7,
            color: '#e1e10d'
         }, {
            start: 7,
            end: 10,
            color: '#fe1229'
         }],
      });
   },1000)


});



