<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      <!-- {{ __('Dashboard') }} --> Welcome {{Auth::user()->name}}
    </h2>

    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>


  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
          @endif
          <form action="{{url('dashboard')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <lable>Name</lable>
              <input type="text" name="name" required value="{{Auth::user()->name}}" class="form-control">
            </div>

            <div class="form-group">
              <lable>DOB</lable>
              <input type="date" name="dob" value="{{Auth::user()->userProfile->dob ?? null}}" class="form-control">
            </div>

            <div class="form-group">
              <input type="radio" id="male" name="gender" value="male" <?php if (isset(Auth::user()->userProfile->gender)) {
                                                                          if (Auth::user()->userProfile->gender == "male") {
                                                                            echo 'checked';
                                                                          }
                                                                        } ?>>
              <label for="html">Male</label><br>
              <input type="radio" id="female" name="gender" value="female" <?php if (isset(Auth::user()->userProfile->female)) {
                                                                              if (Auth::user()->userProfile->gender == "female") {
                                                                                echo 'checked';
                                                                              }
                                                                            } ?>>
              <label for="css">Female</label><br>
            </div>

            <div class="form-group">
              <lable>About</lable>
              <textarea name="about" class="form-control">{{Auth::user()->userProfile->about ?? null}}</textarea>
            </div>

            <div class="form-group">
              <lable>Image</lable>
              <input type="file" name="profile_image" class="form-control">
              @if(isset(Auth::user()->userProfile->profile_image))
              <img src="{{asset('uploads/user/'.Auth::user()->userProfile->profile_image)}}" alt="img" width="100">
              @endif
            </div>

            <!-- <div class="form-group">
              <lable>Location</lable>
              <input type="text" name="autocomplete" id="autocomplete" value="" placeholder="Choose Location" class="form-control">
            </div> -->

            <div class="form-group" id="latitudeArea" style="display: none;">
              <label>Latitude</label>
              <input type="text" id="latitude" name="latitude" class="form-control">
            </div>

            <div class="form-group" id="longtitudeArea" style="display: none;">
              <label>Longitude</label>
              <input type="text" name="longitude" id="longitude" class="form-control">
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-success" value="Update">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
<script>
  $(document).ready(function() {
    $("#latitudeArea").addClass("d-none");
    $("#longtitudeArea").addClass("d-none");
  });
</script>
<script>
  google.maps.event.addDomListener(window, 'load', initialize);

  function initialize() {
    var input = document.getElementById('autocomplete');

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function() {

      var place = autocomplete.getPlace();

      $('#latitude').val(place.geometry['location'].lat());
      $('#longitude').val(place.geometry['location'].lng());

      $("#latitudeArea").removeClass("d-none");
      $("#longtitudeArea").removeClass("d-none");

    });
  }
</script>

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>

<script>
  var firebaseConfig = {
    apiKey: "AIzaSyCtKFUBVL6zhNirGbMHriqKmu3mmXjuYcs",
    authDomain: "utility-braid-320711.firebaseapp.com",
    databaseURL: "https://XXXX.firebaseio.com",
    projectId: "utility-braid-320711",
    storageBucket: "utility-braid-320711.appspot.com",
    messagingSenderId: "559674762067",
    appId: "1:559674762067:web:d9046214cfc76abb5337a6",
    measurementId: "G-SG6F6KBW9V"
  };



  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  function initFirebaseMessagingRegistration() {
    messaging
      .requestPermission()
      .then(function() {
        return messaging.getToken()
      })

      .then(function(token) {
        console.log(token);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: '{{ route("save-token") }}',
          type: 'POST',
          data: {
            token: token
          },

          dataType: 'JSON',

          success: function(response) {
            alert('Token saved successfully.');
          },

          error: function(err) {
            console.log('User Chat Token Error' + err);
          },
        });

      }).catch(function(err) {
        console.log('User Chat Token Error' + err);
      });
  }

  messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
      body: payload.notification.body,
      icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
  });
</script>