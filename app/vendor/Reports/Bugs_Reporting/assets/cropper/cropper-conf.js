$(function() {
      var $cropper = $(".cropper"),
          $dataX = $("#dataX"),
          $dataY = $("#dataY"),
          $dataHeight = $("#dataHeight"),
          $dataWidth = $("#dataWidth"),
          $dataRotate = $("#dataRotate"),
          console = window.console || {log:$.noop},
          cropper;

      $cropper.cropper({
        aspectRatio: 16 / 9,
        data: {
          x: 420,
          y: 50,
          width: 640,
          height: 360
        },
        preview: ".preview",

        // autoCrop: false,
        // dragCrop: false,
        // modal: false,
        // moveable: false,
        // resizeable: false,
        // scalable: false,

        // maxWidth: 480,
        // maxHeight: 270,
        // minWidth: 160,
        // minHeight: 90,

        done: function(data) {
          $dataX.val(data.x);
          $dataY.val(data.y);
          $dataHeight.val(data.height);
          $dataWidth.val(data.width);
          $dataRotate.val(data.rotate);
        },
        build: function(e) {
          console.log(e.type);
        },
        built: function(e) {
          console.log(e.type);
        },
        dragstart: function(e) {
          console.log(e.type);
        },
        dragmove: function(e) {
          console.log(e.type);
        },
        dragend: function(e) {
          console.log(e.type);
        }
      });

      cropper = $cropper.data("cropper");

      $cropper.on({
        "build.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "built.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragstart.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragmove.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragend.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        }
      });

      $("#reset").click(function() {
        $cropper.cropper("reset");
      });

      $("#reset2").click(function() {
        $cropper.cropper("reset", true);
      });

      $("#clear").click(function() {
        $cropper.cropper("clear");
      });

      $("#destroy").click(function() {
        $cropper.cropper("destroy");
      });

      $("#enable").click(function() {
        $cropper.cropper("enable");
      });

      $("#disable").click(function() {
        $cropper.cropper("disable");
      });

      $("#zoomIn").click(function() {
        $cropper.cropper("zoom", 0.1);
      });

      $("#zoomOut").click(function() {
        $cropper.cropper("zoom", -0.1);
      });

      $("#rotateLeft").click(function() {
        $cropper.cropper("rotate", -90);
      });

      $("#rotateRight").click(function() {
        $cropper.cropper("rotate", 90);
      });

      $("#setAspectRatio").click(function() {
        $cropper.cropper("setAspectRatio", $("#aspectRatio").val());
      });

      $("#replace").click(function() {
        $cropper.cropper("replace", $("#replaceWith").val());
      });

      $("#getImageData").click(function() {
        $("#showImageData").val(JSON.stringify($cropper.cropper("getImageData")));
      });

      $("#setData").click(function() {
        $cropper.cropper("setData", {
          x: $dataX.val(),
          y: $dataY.val(),
          width: $dataWidth.val(),
          height: $dataHeight.val(),
          rotate: $dataRotate.val()
        });
      });

      $("#getData").click(function() {
        $("#showData").val(JSON.stringify($cropper.cropper("getData")));
      });

      $("#getDataURL").click(function() {
        var dataURL = $cropper.cropper("getDataURL");

        $("#dataURL").text(dataURL);
        $("#showDataURL").html('<img src="' + dataURL + '">');
      });

      $("#getDataURL2").click(function() {
        var dataURL = $cropper.cropper("getDataURL", "image/jpeg");

        $("#dataURL").text(dataURL);
        $("#showDataURL").html('<img src="' + dataURL + '">');
      });
    });