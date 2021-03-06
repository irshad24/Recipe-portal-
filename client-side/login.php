<title>Login</title>
<div class = "login-background" style="height: 93%;">
<div class="container loginForm  background-container col-sm-10 col-lg-4 col-lg-offset-4  col-sm-offset-1">
  <h2>Login</h2>
  <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "invaliddetails") {
                        echo '<p class="text-danger" style="font-weight: bold; margin-top: 8px">Invalid Details</p>';
                    }
                    else if ($_GET["error"] == "none") {
                      echo '<p class="text-success" style="font-weight: bold; margin-top: 8px">Success! Your registration is complete!</p>';
                  }
                    else if ($_GET["error"] == "alreadyregistered"){
                      echo '<p class="text-danger" style="font-weight: bold; margin-top: 8px">Email is already registered. </p>';
                    }
                }
  ?>
  <form action="" method="POST">
    <div class="form-group loginInput">
      <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required>
    </div>
    <div class="form-group loginInput">
      <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
  </form>
  <label class="notReg">Not registered?</label> <a href="" data-toggle="modal" data-target="#signUp">Create account</a>
</div>
<br>
</div>
<?php
// check if user is logedin
  if(isset($_SESSION['Logedin'])){
    $Logedin=$_SESSION['Logedin'];
    if($Logedin===1){
      header('Location: client-side/food.php');
    }
  }else{
    $Logedin=0;
  }
  //  Login function
  function Login(){
    // get connection database form config.php
    require "server-side/config.php";
    $email = $_POST['email'];
    $password =  md5($_POST['password']);
    // check user email and password match
    $checkUser = mysqli_query($connect,"SELECT * FROM users WHERE email = '$email' AND password='$password'");
    $count = mysqli_num_rows($checkUser);
    // check if got no data from database
    if ($count == 0) {
      header('Location: index.php?error=invaliddetails');
     } else {
    // if user and password correct
    while($data = mysqli_fetch_array($checkUser)){
      // set sessions
      $_SESSION['user'] = $data['id'];
      $_SESSION['name'] = $data['name'];
      $_SESSION['mail'] = $data['email'];
      $_SESSION['Logedin']=1;
      header('Location: client-side/food.php');
      }
    }
  }
  function check(){
    // get connection database form config.php
    require "server-side/config.php";
    //  check if email is defined in database
    $checkEmail = mysqli_query($connect,"SELECT * FROM users WHERE email = '$_POST[email]'");
    if($row = mysqli_fetch_array($checkEmail)){
      Login();
    }else{
      echo '<div class="col-sm-10 col-lg-4 col-lg-offset-4  col-sm-offset-1">
              <div class="alert alert-danger">
                This email is not registered.
              </div>
            </div>';
    }
  }
  // call check function when post form (login)
  if(isset($_POST['login'])){
    check();
  }
 ?>
