@extends('example-layout')
@section('content')
   <div class="container">
      <h1>Example View Loaded</h1>
      <p>
         Start by setting up your new view by creating a .blade file in the Views directory.
         You can then connect that up in the Route/web.php file. Don't forget to also connect a
         layout!
      </p>
   </div>
   <div class="container">
      <h1>Using Parameters</h1>
      <p>
         Setup Parameters by adding {your_paramter_name} in the routes URI. The route has found
         that ID has been set as {{ $id }}.
      </p>
   </div>
   <div class="container">
      <h1>Latest Features</h1>
      <ul>
         <li>URL Parameters: Handle parameters via the URI</li>
         <li>Docker Setup: Containerized development environment</li>
      </ul>
   </div>
@endsection