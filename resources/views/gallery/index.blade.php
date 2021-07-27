<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>
</head>
<body>

<h2>Gallery</h2>
<a href="{{url('add-gallery')}}">Add Gallery</a>

<table style="width:100%">
  <tr>
    <th>Sr.no.</th>
    <th>Image</th>
  </tr>
  
   @if(count(Auth::user()->images)>0)
	    @foreach(Auth::user()->images as $i=> $image)
  <tr>
    <td>{{$i+1}}</td>
    <td><img src="{{asset('uploads/image/'.$image->image)}}" width="100" alt="img"></td>
  </tr>
     @endforeach
  @endif
</table>

</body>
</html>
