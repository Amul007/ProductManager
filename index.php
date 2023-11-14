<?php 
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=product', 'root' ,'');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $statement = $pdo->prepare('select * from products order by create_date desc');
  $statement->execute();
  $products = $statement-> fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   
    <title>products_curds</title>
  </head>
  <body>
    <h1>Products</h1>
    <p>
      <a href="create.php" class="btn btn-success">Create Product</a>
    </p>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php 
       foreach($products as $i=>$prod):?>
    <tr>
      <th scope="row"><?php echo $i+1?></th>
      <td>
        <img src="<?php echo $prod['image']?>" class="thumb-image">
      </td>
      <td><?php echo $prod['title']?></td>
      <td><?php echo $prod['price']?></td>
      <td><?php echo $prod['create_date']?></td>
      <td>
      <a href="update.php?id=<?php echo $prod['id'] ?>" class=" btn btn-sm btn-primary">Edit</a>

      <form style="display:inline-block;" action="delete.php" method="post">
      <input type="hidden" name="id" value="<?php echo $prod['id']?>">
      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
      </form>
      </td>
      <td><?php echo $prod['title']?></td>
    </tr>
       <?php endforeach;
      ?>
  </tbody>
</table>
  </body>
</html>