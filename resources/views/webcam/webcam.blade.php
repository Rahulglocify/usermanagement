<!DOCTYPE html>
<html>

<head>
  <title>Capture webcam image with php and jquery - pakainfo.com</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <style type="text/css">
    #preview {
      padding: 30px;
      border: 1px solid;
      background: #3d3d3d;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1 class="text-center">Capture webcam image with php and jquery - pakainfo.com</h1>
    <p>Integrate Webcam Capture in a PHP Application</p>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
    </div>
    @endif
    <form method="POST" action="{{url('/webcam')}}">
      @csrf
      <div class="row pakainfo">
        <div class="col-md-6 pakainfo">
          <div id="live_camera"></div>
          <hr />
          <input type=button value="Take Snapshot" onClick="capture_web_snapshot()">
          <input type="hidden" name="image" class="image-tag">
        </div>
        <div class="col-md-6">
          <div id="preview">Your captured image will appear here...</div>
        </div>
        <div class="col-md-12 text-center pakainfo">
          <br />
          <button class="btn btn-primary pakainfo">Submit</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Settings a few settings and (php capture image from camera) web attach camera -->
  <script language="JavaScript">
    Webcam.set({
      width: 490,
      height: 390,
      image_format: 'jpeg',
      jpeg_quality: 90
    });

    Webcam.attach('#live_camera');

    function capture_web_snapshot() {
      Webcam.snap(function(site_url) {
        $(".image-tag").val(site_url);
        document.getElementById('preview').innerHTML = '<img src="' + site_url + '"/>';
      });
    }
  </script>

</body>

</html>