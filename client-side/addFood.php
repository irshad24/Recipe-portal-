<!-- add recipe modal -->
<div class="modal fade" id="addFood" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <input type="file" class="form-control" id="file" name="image">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="name" placeholder="Dish name" name="name" required>
        </div>
        <div class="form-group">
          <textarea id="subject" class="form-control" name="ingredients" placeholder="Ingredients required" style="height:100px" required></textarea>
        </div>
        <div class="form-group">
          <textarea id="subject" class="form-control" name="description" placeholder="Enter recipe!" style="height:200px" required></textarea>
        </div>
        <button type="submit" name="addFood" class="btn" style="background-color: #422929; color: white;">Post!</button>
      </form>
      </div>
    </div>
  </div>
</div>
<?php
$Logedin=$_SESSION['Logedin'];
  function addFood(){
    // get connection database form config.php
    require "../server-side/config.php";
    // check if image name already added to database
    if (isset($_FILES["image"]["name"])) {
        $name = $_FILES["image"]["name"];
        $checkImage = mysqli_query($connect,"SELECT * FROM recipes WHERE image = '$name'");
        if($row = mysqli_fetch_array($checkImage)){
          echo '<div class="container alert alert-danger" style="margin-top: 10px;">
          Wrong! image name already exists</div>';
        }else{
          $tmp_name = $_FILES['image']['tmp_name'];
          $error = $_FILES['image']['error'];
          if (!empty($name)) {
            //  upload image to uploads/ folder
            $location = 'uploads/';
            if(move_uploaded_file($tmp_name, $location.$name)){}
          }
          // get information from post
        $image = $_FILES["image"]["name"];
        $name = $_POST['name'];
        $ingredients = $_POST['ingredients'];
        $description = $_POST['description'];
        $author = $_SESSION['name'];
        $insertRecipe = "INSERT INTO recipes (name,image,author,ingredients,description,date) VALUES ('$name','$image','$author','$ingredients','$description',now())";
        $data = mysqli_query ($connect,$insertRecipe);
        // check if post published
        if($data){
          echo '<div class="container alert alert-success" style="margin-top: 10px;">
          <strong>Success!</strong> published</div>';
        }
      }
    }
  }
  // call addFood function if got addFood post
    if(isset($_POST['addFood'])){
    	addFood();
    }
   ?>
