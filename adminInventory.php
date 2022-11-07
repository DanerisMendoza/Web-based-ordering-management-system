<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.6.1.min.js"></script>  
    <script type="text/javascript" src="js/bootstrap.min.js"></script>  

</head>
<body>
  <div class="container text-center">
    <button class="btn btn-success col-sm-4" id="admin">Admin</button>
    <button id="addButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">Add new dish</button>
    <script>document.getElementById("admin").onclick = function () {window.location.replace('admin.php'); };</script> 
   
   <div class="col-lg-12">
			<table class="table table-striped" border="10">
			  <thead>
			    <tr>	
            <th scope="col">picture</th>
			      <th scope="col">Dishes</th>
			      <th scope="col">Price</th>
			      <th scope="col">Cost</th>
			      <th scope="col">Stock</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
             include('dishesClass.php');
             $dish = new dish();
             $result = $dish -> getAllDishes();
			  	   foreach($result as $rows){
			  	 ?>
			    <tr>	   
          <td><?php $pic = $rows['picName']; echo "<img src='dishesPic/$pic' style=width:100px;height:100px>";?></td>
          <td><?=$rows['dish']?></td>
          <td><?php echo '₱'.$rows['price']; ?></td>
          <td><?php echo '₱'.$rows['cost']; ?></td>
          <td><?php echo $rows['stock']; ?></td>
				  <td><a href="?idAndPicnameDelete=<?php echo $rows['orderType']." ".$rows['picName'] ?>">Delete</a></td>
				  <td><a href="adminInventoryUpdate.php?idAndPicnameUpdate=<?php echo $rows['orderType']." ".$rows['dish']." ".$rows['price']." ".$rows['picName']." ". $rows['cost']." ".$rows['stock'] ?>"  >Update</a></td>
			    </tr>
			    <?php } ?>
			  </tbody>
			</table>
		</div>
  </div>
  
  <div class="modal fade" role="dialog" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body ">
                <form method="post" class="form-group" enctype="multipart/form-data">
                    <input type="text" class="form-control" name="dishes" placeholder="dishes">
                    <input type="number" class="form-control" name="price" placeholder="price">
                    <input type="number" class="form-control" name="cost" placeholder="cost">
                    <input type="number" class="form-control" name="stock" placeholder="stock">
                    <input type="file"  name="fileInput">
                    <button type="submit" class="btn-success col-sm-12" name="insert">insert</button>
                </form>
                <?php
                               
                //delete 
                if (isset($_GET['idAndPicnameDelete'])){
                  $arr = explode(' ',$_GET['idAndPicnameDelete']);
                  $id = $arr[0];
                  $pic = $arr[1];
                  $dish = new dish($id, $pic);
                  $dish ->deleteDishOnDatabase();
                }

                //insert
                if(isset($_POST['insert'])){
                $dishes = $_POST['dishes'];
                $price = $_POST['price'];
                $cost = $_POST['cost'];
                $file = $_FILES['fileInput'];
                $stock = $_POST['stock'];
                if(empty($dishes) || empty($price) || empty($cost) || empty($stock) || $_FILES['fileInput']['name']==''){
                  echo "<script>alert('Please complete the details!'); window.location.replace('adminInventory.php');</script>";
                  return;
                }
                if($price < $cost){
                  echo "<script>alert('Cost should be less than price!'); window.location.replace('adminInventory.php');</script>";
                  return;
                }
                $fileName = $_FILES['fileInput']['name'];
                $fileTmpName = $_FILES['fileInput']['tmp_name'];
                $fileSize = $_FILES['fileInput']['size'];
                $fileError = $_FILES['fileInput']['error'];
                $fileType = $_FILES['fileInput']['type'];
                $fileExt = explode('.',$fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                if(in_array($fileActualExt,$allowed)){
                    if($fileError === 0){
                        if($fileSize < 10000000){
                            $fileNameNew = uniqid('',true).".".$fileActualExt;
                            $fileDestination = 'dishesPic/'.$fileNameNew;
                            move_uploaded_file($fileTmpName,$fileDestination);         
                            $dish = new dish($dishes, $price, $fileNameNew, $cost, $stock);
                            $dish->insertNewDishToDatabase();        
                            echo "<script>window.location.replace('adminInventory.php')</script>";                                
                        }
                        else
                            echo "your file is too big!";
                    }
                    else
                        echo "there was an error uploading your file!";
                }
                else
                    echo "you cannot upload files of this type";     
                }
                ?>
            </div>
        </div>
    </div>
  </div>
</body>
</html>