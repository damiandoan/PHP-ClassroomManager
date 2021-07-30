<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Add Class</title>
</head>
<body>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
    <a class="navbar-brand" href="#">
     <h2>Classes Management System</h2>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Add class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Search</a>
        </li>
        <!-- Dropdown -->
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Options
      </a>
      <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Link 1</a>
          <a class="dropdown-item" href="#">Link 2</a>
          <a class="dropdown-item" href="#">Link 3</a>
      </div>
      </li>    
      </ul>
    </div>  
  </nav>


<div class="container ac1">
  
  <section class="panel panel-default">
<div class="panel-heading"> 
<h3 class="panel-title ad2" >Add class</h3> 
</div> 
<div class="panel-body">
  
  <form action="designer-finish.html" class="form-horizontal" role="form">
    <!-- form-group // -->
    <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Class name</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="classname" id="name" placeholder="enter class name">
      </div>
    </div> 
      <!-- form-group // -->
    <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Subject</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="Subject" id="name" placeholder="enter subject">
      </div>
    </div> 
    <!-- form-group // -->
    <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Classroom</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="Classroom" id="name" placeholder="enter classroom">
      </div>
    </div> 
    <!-- form-group // -->
    <!-- form-group // -->
    <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Avatar</label>
      <div class="col-sm-3">
        <label class="control-label small" for="file_img">File(jpg/png):</label> <input type="file" name="file_img">
      </div>
    </div> <!-- form-group // -->
  <!-- form-group // -->
    <hr>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-9">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div> <!-- form-group // -->
  </form>
  
</div><!-- panel-body // -->
</section><!-- panel// -->

  
</div> <!-- container// -->



</body>
</html>