<?php
  $page = 'customer';
  include('method/checkIfAccountLoggedIn.php');
  include_once('method/query.php');
  $query = "select a.name, b.feedback from  WEBOMS_userInfo_tb a inner join WEBOMS_feedback_tb b on a.user_id = b.user_id";
  $resultSet =  getQuery($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback List</title>
        <!-- for modal -->
        <link rel="stylesheet" href="css/bootstrap 5/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/customer.css">
        <script type="text/javascript" src="js/bootstrap 5/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-3.6.1.min.js"></script>
        <!-- online css bootsrap icon -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <!-- data table -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    </head>

    <body>
        <div class="container text-center mt-5">
            <!-- back button -->
            <button class="btn btn-lg btn-dark col-12 mb-4" id="back"><i class="bi bi-arrow-left me-1"></i>BACK</button>
            <script>
            document.getElementById("back").onclick = function() {
                window.location.replace('customerMenu.php');
            };
            </script>

            <!-- table -->
            <div class="table-responsive col-lg-12">
                <table class="table table-bordered col-lg-12" id="tb1">
                    <thead>
                        <tr>
                            <th scope="col">NAME</th>
                            <th scope="col">FEEDBACK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($resultSet!= null)
                            foreach($resultSet as $row){ ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['feedback'];?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php ?>
            </div>
        </div>
    </body>
</html>
<script>
    $(document).ready(function() {
        $('#tb1').DataTable();
    });
</script>