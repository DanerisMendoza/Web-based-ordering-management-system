<?php
    $page = 'notLogin';
    $isFromLogin = true;
    include('../method/checkIfAccountLoggedIn.php');
    include('../method/query.php');
    include_once('connection.php');
    $query = "select * from weboms_company_tb";
    $resultSet = getQuery2($query);
    if($resultSet!=null){
        foreach($resultSet as $row){
            $name = $row['name'];
            $address = $row['address'];
            $tel = $row['tel'];
            $description = $row['description'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR CODE</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../css/qr-code.css">
    <link rel="icon" href="../image/weboms.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body class="qr-bg">

    <a href="../index.php" class="back-home"><i class="bi-arrow-left"></i>BACK TO HOME</a>
    <div class="container qr-container">
        <div class="col-sm-12">
            <div class="row">
                <!-- register qr -->
                <div class="col-sm-6">
                    <center>
                        <img src="../image/register.png">
                        <label for="" class="register-here">REGISTER HERE</label>
                    </center>
                </div>

                <!-- mobile apk -->
                <div class="col-sm-6"> 
                    <center>
                        <img src="../image/mobile.png">
                        <label for="" class="mobile-here">MOBILE APPLICATION</label> <br>
                        <a href="http://ucc-csd-bscs.com/WEBOMS/WebomsMobile.apk" class="mobile-link text-danger">http://ucc-csd-bscs.com/WEBOMS/WebomsMobile.apk</a>
                    </center>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
