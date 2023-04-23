<?php 
  $page = 'cashier';
  include('../method/checkIfAccountLoggedIn.php');
  include('../method/query.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Queue</title>

    <link rel="stylesheet" href="../css/bootstrap 5/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script type="text/javascript" src="../js/bootstrap 5/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery-3.6.1.min.js"></script>
    <!-- online css bootsrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- ajax -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header bg-dark">
                <h3 class="mt-3"><a href="admin.php"><?php echo ucwords($_SESSION['accountType']); ?></a></h3>
            </div>
            <ul class="list-unstyled components ms-3">
                <li class="mb-2">
                    <a href="adminPos.php"><i class="bi bi-tag me-2"></i>Point of Sales</a>
                </li>
                <li class="mb-2">
                    <a href="adminOrders.php"><i class="bi bi-minecart me-2"></i>Orders</a>
                </li>
                <li class="mb-2 active">
                    <a href=""><i class="bi bi-clock me-2"></i>Orders Queue</a>
                </li>
                <li class="mb-2">
                    <a href="topupRfid.php"><i class="bi bi-credit-card me-2"></i>Top-Up RFID</a>
                </li>
            
            <?php if($_SESSION['accountType'] != 'cashier'){?>
                <li class="mb-2">
                    <a href="adminInventory.php"><i class="bi bi-box-seam me-2"></i>Inventory</a>
                </li>
                <li class="mb-2">
                    <a href="adminSalesReport.php"><i class="bi bi-bar-chart me-2"></i>Sales Report</a>
                </li>
                <li class="mb-2">
                    <a href="accountManagement.php"><i class="bi bi-person-circle me-2"></i>Account Management</a>
                </li>
                <li class="mb-2">
                    <a href="adminFeedbackList.php"><i class="bi bi-chat-square-text me-2"></i>Customer Feedback</a>
                </li>
                <li class="mb-2">
                    <a href="adminTopUp.php"><i class="bi bi-cash-stack me-2"></i>Top-Up</a>
                </li>
                <li class="mb-1">
                    <a href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a>
                </li>
            <?php } ?>

                <li>
                    <form method="post">
                        <button class="btn btnLogout btn-dark text-danger" id="Logout" name="logout"><i class="bi bi-power me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid bg-transparent">
                    <button type="button" id="sidebarCollapse" class="btn" style="font-size:20px;"><i class="bi bi-list"></i> Toggle</button>
                </div>
            </nav>

            <!-- content here -->
            <div class="container-fluid text-center">
                <div class="row justify-content-center">

                    <!-- serving table -->
                    <div class="table-responsive col-lg-6">
                        <table class="table table-bordered table-hover col-lg-12" id="tableServing">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th scope="col"><h2><i class="bi bi-arrow-bar-left"></i> SERVING</h2></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- serving table -->
                                    <?php   
                                        $getServingOrder = "select a.name, b.* from weboms_userInfo_tb a right join weboms_order_tb b on a.user_id = b.user_id WHERE b.status = 'serving' ORDER BY b.id asc; ";
                                        $resultSet = getQuery2($getServingOrder);
                                        if($resultSet != null)
                                            foreach($resultSet as $row){ 
                                    ?>
                                                <tr>
                                                    <!-- orders id -->
                                                    <td><strong style="font-size: 35px;"><?php echo $row['order_id']; ?></strong></td>
                                                </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- prepairing table -->
                    <div class="table-responsive col-lg-6">
                        <table class="table table-bordered table-hover col-lg-12" id="prepairingTable">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th scope="col"><h2><i class="bi bi-clock"></i> PREPARING</h2></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   
                                    $getPrepairingOrder = "select a.name, b.* from weboms_userInfo_tb a right join weboms_order_tb b on a.user_id = b.user_id WHERE b.status = 'preparing'  ORDER BY b.id asc; ";
                                    $resultSet = getQuery2($getPrepairingOrder);
                                    if($resultSet != null)
                                        foreach($resultSet as $row){ 
                                ?>
                                            <tr>
                                                <!-- orders id -->
                                                <td><strong style="font-size: 35px;"><?php echo $row['order_id']; ?></strong></td>
                                            </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
// auto refresh 
function autoRefresh_Tables() {
    $("#tableServing").load("adminOrdersQueue.php #tableServing", function() {
        setTimeout(autoRefresh_Tables, 2000);
    });
    $("#prepairingTable").load("adminOrdersQueue.php #prepairingTable", function() {
        setTimeout(autoRefresh_Tables, 2000);
    });
}
autoRefresh_Tables();

// sidebar toggler
$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
});
</script>

<?php 
    if(isset($_POST['logout'])){
        session_destroy();
        echo "<script>window.location.replace('../index.php');</script>";
    }
?>