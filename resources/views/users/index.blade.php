<!DOCTYPE html>
<html>

<head>
  <style>
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 5px;
      text-align: left;
    }
  </style>
</head>

<body>
  <h2>All Users List</h2>

  <table style="width:100%">
    <tr>
      <th>Sr.no.</th>
      <th>Name</th>
      <th>DOB</th>
      <th>About</th>
      <th>Image</th>
    </tr>

    @if(count($users)>0)
    @foreach($users as $i=> $user)
    <tr>
      <td>{{$i+1}}</td>
      <td>{{$user->name}}</td>
      <td>{{$user->userProfile->dob ?? null}}</td>
      <td>{{$user->userProfile->about ?? null}}</td>
      <td>
        @if(isset($user->userProfile->profile_image))
        <img src="{{asset('uploads/user/'.$user->userProfile->profile_image)}}" width="100" alt="img">
        @endif
      </td>
    </tr>
    @endforeach
    @endif
  </table>
</body>

</html>