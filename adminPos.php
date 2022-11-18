<?php 
  include('method/checkIfAccountLoggedIn.php');
  if(!isset($_SESSION["dishes"]) && !isset($_SESSION["price"])){
    $_SESSION["dishes"] = array();
    $_SESSION["price"] = array(); 
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin POS</title>
        
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
   
</head>
<body class="bg-light">
          
<div class="container text-center">
  <div class="row justify-content-center">
    <h1 class="font-weight-normal mt-5 mb-4">Point of Sales</h1>
    <button class="btn btn-lg btn-danger col-12 mb-3" id="admin">Admin</button>
    <button  type="button" class="btn btn-lg btn-success col-12 mb-4" id="viewCart" >View Cart</button>
              
    <script>document.getElementById("admin").onclick = function () {window.location.replace('admin.php'); };</script> 
    <script>document.getElementById("viewCart").onclick = function () {window.location.replace('adminCart.php'); };</script> 
              
    <div class="table-responsive col-lg-12">
            <?php 
                include('method/Query.php');
                $query = "select * from menu_tb";
                $resultSet =  getQuery($query)
            ?>
      <table class="table table-striped table-bordered mb-5 col-lg-12">
        <thead class="table-dark">
          <tr>	
            <th scope="col">DISH</th>
            <th scope="col">PRICE</th>
            <th scope="col">Stock</th>
            <th scope="col">IMAGE</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if($resultSet != null)
            foreach($resultSet as $rows){ ?>
            <tr>	   
                <td><?=$rows['dish']?></td>
                <td><?php echo '₱'.$rows['price']; ?></td>
                <td><?php echo $rows['stock']; ?></td>
                <td><?php $pic = $rows['picName']; echo "<img src='dishesPic/$pic' style=width:100px;height:100px>";?></td>
                <td><a class="btn btn-light border-dark" 
                    <?php   if($rows['stock'] <= 0) 
                                echo "<button>Out of stock</button>";
                            else{
                    ?>
                    href="?order=<?php echo $rows['dish'].",".$rows['price'].",".$rows['orderType']?>" >Add To Cart</a><?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>

<?php 
    //add to cart
    if(isset($_GET['order'])){
      $order = explode(',',$_GET['order']);  
      $dish = $order[0];
      $price = $order[1];
      array_push($_SESSION['dishes'], $dish);
      array_push($_SESSION['price'], $price);
      $updateQuery = "UPDATE menu_tb SET stock = (stock - 1) WHERE dish= '$dish' ";    
      if(Query($updateQuery))
        echo "<script>window.location.replace('adminPos.php');</script>";    
    }
?>