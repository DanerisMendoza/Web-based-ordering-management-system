<?php
    $page = 'admin';
    include('method/checkIfAccountLoggedIn.php');
    include('method/query.php');
    //init
    $_SESSION['from'] = 'adminSalesReport';
    $_SESSION['resultSet'] = array();
    $_SESSION['date1'] =  $_SESSION['date2'] = '';


    //default value
    $query = "select WEBOMS_userInfo_tb.name, WEBOMS_order_tb.* from WEBOMS_userInfo_tb, WEBOMS_order_tb where WEBOMS_userInfo_tb.user_id = WEBOMS_order_tb.user_id and WEBOMS_order_tb.status = 'complete' ORDER BY WEBOMS_order_tb.id asc; ";
    $resultSet =  getQuery($query); 
  
    //fetch by date
    if(isset($_POST['fetch'])){
        if($_POST['dateFetch1'] != '' && $_POST['dateFetch2'] != ''){
            $date1 = $_POST['dateFetch1'];
            $date2 = $_POST['dateFetch2'];

            $_SESSION['date1'] = date('m/d/Y h:i a ', strtotime($date1));
            $_SESSION['date2'] = date('m/d/Y h:i a ', strtotime($date2));
            $query = "select WEBOMS_userInfo_tb.name, WEBOMS_order_tb.* from WEBOMS_userInfo_tb, WEBOMS_order_tb where WEBOMS_userInfo_tb.user_id = WEBOMS_order_tb.user_id and WEBOMS_order_tb.status = 'complete' and WEBOMS_order_tb.date between '$date1' and '$date2' ORDER BY WEBOMS_order_tb.id asc; ";
            $resultSet =  getQuery($query); 
            $_SESSION['resultSet'] = array();
        }
    }
 
    //show all
    if(isset($_POST['showAll'])){
        $query = "select WEBOMS_userInfo_tb.name, WEBOMS_order_tb.* from WEBOMS_userInfo_tb, WEBOMS_order_tb where WEBOMS_userInfo_tb.user_id = WEBOMS_order_tb.user_id and WEBOMS_order_tb.status = 'complete' ORDER BY WEBOMS_order_tb.id asc; ";
        $resultSet =  getQuery($query); 
        unset($_POST['dateFetch1']);
        unset($_POST['dateFetch2']);
        $_SESSION['resultSet'] = array();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin SR</title>
        
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

</head>
<body class="bg-light">

<div class="container text-center mt-5">
    <div class="row justify-content-center">
        <button class="btn btn-lg btn-dark col-4 mb-3" id="admin">Admin</button>
        <button class="btn btn-lg btn-success col-4 mb-3" id="viewGraph">View Graph</button>
        <button class="btn btn-lg btn-success col-4 mb-3" id="viewInPdf">View in PDF</button>
        <div class="container-fluid">
            <form method="post">
                <div class="col-12 row">
                    <h5 class="form-control col-2">From:</h5><input type="datetime-local" name="dateFetch1" class="form-control form-control-lg mb-2 col-3" value="<?php echo(isset($_POST['dateFetch1'])?  $_POST['dateFetch1']: " ") ?>" >
                    <h5 class="form-control col-2">To:</h5><input type="datetime-local" name="dateFetch2" class="form-control form-control-lg mb-2 col-3" value="<?php echo(isset($_POST['dateFetch1'])?  $_POST['dateFetch2']: " ") ?>" >
                    <button type="submit" name="fetch" class="btn btn-lg btn-success col-2 mb-2">Fetch(BETWEEN)</button>
                </div>
                <button type="submit" name="showAll" class="btn btn-lg btn-success col-12 mb-3">Show All</button>
            </form>
        </div>
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-bordered col-lg-12">
                    <thead class="table-dark">
                        <tr>	
                            <th scope="col">NAME</th>
                            <th scope="col">TRANSACTION NO</th>
                            <th scope="col">DATE & TIME</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">ORDER DETAILS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if($resultSet != null)
                            foreach($resultSet as $rows){ ?>
                                <?php array_push($_SESSION['resultSet'], $rows)?>
                                <tr>	   
                                <td><?php echo $rows['name']; ?></td>
                                <td><?php echo $rows['order_id'];?></td>
                                <td><?php echo date('m/d/Y h:i a ', strtotime($rows['date'])); ?></td>
                                <td><?php echo '₱'.$rows['totalOrder']; ?></td>
                                <?php $total += $rows['totalOrder'];?>
                                <td><a class="btn btn-light border-dark" href="adminOrder_details.php?idAndPic=<?php echo $rows['order_id']?>">ORDER DETAILS</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4"><strong>Total</strong></td>
                                <td><strong><?php echo '₱'.$total;?></strong></td>
                            </tr>
                    </tbody>
                </table>
            </div>
    </div>
</div>
    
</body>
</html>

<script>
    document.getElementById("admin").onclick = function () {window.location.replace('admin.php'); };
    document.getElementById("viewGraph").onclick = function () {window.location.replace('adminGraph.php'); };
</script>

<script>
    //order button (js)
    document.getElementById("viewInPdf").addEventListener("click", () => {
        if(<?php echo $resultSet == null ? 'true':'false';?>){
            alert('Pdf is Empty!');
            return;
        }
        else{
            window.open("pdf/salesReport.php");
        }
    });
</script>