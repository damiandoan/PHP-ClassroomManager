
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
    <title>classview</title>
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
  <!-- card class -->
  <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card" >
            <div class="card-header">

              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            
            <div class="card-body">
              <img class="card-img-top" src="images/avatar1.jpeg" alt="Card image" style="width:50%" >
              <h4 class="card-title">Dang Minh Thang</h4>
              <p class="card-text">49 student - 30 periods - Room C004</p>
              <a href="#" class="btn btn-primary">Class</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!-- header -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/avatar1.jpeg" alt="Card image" style="width:50%" >
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!-- header -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/images.jpeg" alt="Card image" style="width:50%">
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!--  -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/images.jpeg" alt="Card image" style="width:50%">
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        
      </div>
  </div>
</body>
</html>