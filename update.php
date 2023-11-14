<?php 
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=product', 'root' ,'');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $id = $_POST['id'];
  if(!$id){
    header("Location: index.php");
  }
  echo "<pre>";
  var_dump($id);
  echo "</pre>";
  exit;
  $errors = [];
  $title = '';
  $price = '';
  $description = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $title = $_POST['title'];
      $description = $_POST['description'];
      $price =  $_POST['price'];
      $date = date('Y-m-d H:i:s');

        if(!$title){
          $errors[]= 'products title is  required'; 
        }
        if(!$price){
          $errors[]= 'products price is required';
        }
        if(!is_dir('images')){
          mkdir('images');
        }
        if(empty($errors)){
          $image = $_FILES['image'] ?? null;
          $imagePath = '';
          if($image && $image['tmp_name']){
             $imagePath = 'images/'.randomString(8).'/'.$image['name'];
             mkdir(dirname($imagePath));
             move_uploaded_file($image['tmp_name'],$imagePath);
           }

        if(!is_dir('images')){
            mkdir('images');
        } 

        $statement = $pdo->prepare("insert into products (title, image, description, price, create_date   )
                                values(:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue('description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
        $statement->execute();
        header('Location: index.php');
      }
 }
  function randomString($n){
    $characters = "01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ";
    $str = '';
    for($i=0; $i<$n; $i++){
      $index = rand(0, strlen($characters)-1);
      $str.= $characters[$index];
    }
    return $str;
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" heref="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   
    <title>Product_curd</title>
  </head>
  <body>
    <h1>create new product</h1>
   
    <?php if(!empty($errors)):?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error):?>
        <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
   <?php endif; ?>
  
  <form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Product image</label>
    <input type="file" name="image">
  </div>
  <div class="form-group">
    <label>Product Title</label>
    <input type="text" class="form-control" name="title" value =<?php echo $title?>>
  </div>
  <div class="form-group">
    <label>Product discription</label>
    <textarea class="form-control" name="description"><?php echo $description?></textarea>
  </div>
  <div class="form-group">
    <label>Product price</label>
    <input type="number" step=".01" class="form-control" name="price" value=<?php echo $price?>>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form> 
  </body>
</html>