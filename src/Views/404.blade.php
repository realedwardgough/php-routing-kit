@extends('example-layout')
@section('content')
   <div class="container">
      <h1>404</h1>
      <p>
         The page you tried to load hasn't been setup in the Route/web.php file yet. You can
         start by setting up your new view by creating a .blade file in the Views directory.
         You can then connect that up in the Route/web.php file. Don't forget to also connect a
         layout!
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