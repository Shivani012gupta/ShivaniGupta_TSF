<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    
    <link rel="icon" href="Other/building-solid.svg">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Send money - Sparks Bank</title>
    
</head>

<body>

<?php include 'spin.php'; ?>

    <center>
    <header class="header">

        <!------------------- navbar ---------------->

        <nav class="navbar navbar-style">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#micon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="index.php" style="text-decoration: none;">
                        <div class="logol">
                            <div class="iconl">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="contentl">
                                <p>Sparks bank</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="collapse navbar-collapse" id="micon">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="send_money.php"><u>Send Money</u></a></li>
                        <li><a href="all_cust.php">View All Customer</a></li>
                        <li><a href="transactions.php">Transactions</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-------------------  ---------------->

        <div class="container2s">
            <div>
                <h1>Transfer Money</h1>
            </div>
            <hr>
            <div class="" style=" backdrop-filter: blur(5px);  border-radius:5px;  ">
                <form action="send_money.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <input type="text" 
                                    class="formin form-control" name="accno1" id=""
                                    placeholder="Sender's Account Number"
                                    value="<?php if(isset($_GET['reads'])){echo $_GET['reads'];} ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="number" class="formin form-control" name="amount" id=""
                                    placeholder="Amount to Transfer">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" class="formin form-control" name="accno2" id=""
                                    placeholder="Reciever's Account Number">
                            </td>
                        </tr>
                    </table>

                    <input class="btn mybtn btn-outline-light" type="submit" value="Transfer">

                    <p style="padding: 10px 10px 20px 10px;">Want to check your balance? check <a href="check_blc.php">here</a></p>
                </form>
            </div>
        </div>

        <!------------------- style ---------------->

        <style>
            .container2s{
                width: 90%;
                height: max-content;
                background:white;
                border-radius: 6px;
                justify-content: center;
                margin: 25px 0px;
                box-shadow: 10px 10px 25px rgba(0, 0, 0, 0.226);
                
            }

            .container2s h1{
                color: black;
                padding:50px 15px 15px 15px; 
                border-radius:30px;
            }

            h1:hover{
                transition: .5s;
                color: rgb(32, 98, 208);
            }

            .formin {
                border-radius: 6px;
                width: 380px;
                height: 50px;
                padding: 5px 5px 5px 15px;
            }

            .mybtn {
                width: 380px;
                background-color: white;
                margin: 20px auto;
                
                border-style: solid;
                border-width: 2px;
                border-color: rgb(32, 98, 208);

                border-radius: 6px;
                font-weight: bold;
            }

            .mybtn:hover{
                transition: 0.3s;
                background-color: rgb(32, 98, 208) ;
                color: white;
                box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.226);
            }
            .mybtn:active {
                background-color: rgb(32, 98, 208);
            }

            td {
                padding-top: 10px;
                padding-bottom: 10px;
            }
    </style>

    <!------------------- php ---------------->

    <?php
        $conn = mysqli_connect($servername, $username, $password, $database);
        if(!$conn){
            die("Connection not established: ".mysqli_connect_error());
        }

        else{

                if($_SERVER['REQUEST_METHOD']== 'POST'){

                    $sender = $_POST['accno1'];
                    $amount = $_POST['amount'];
                    $reciever = $_POST['accno2'];
                            
                    $checkblcquery = "SELECT blc FROM users where accno='$sender'";
                    $checkblc = mysqli_query($conn, $checkblcquery);
                    $ava_blc = mysqli_fetch_assoc($checkblc)['blc'];

                    if($ava_blc >= $amount){
                        $sql1 = "UPDATE users SET blc= blc-$amount WHERE accno='$sender'";
                        $sql2 = "UPDATE users SET blc= blc+$amount WHERE accno='$reciever'";
                        $result1 = mysqli_query($conn, $sql1);  
                        $result2 = mysqli_query($conn, $sql2);
                        if($result1 && $result2){
                            echo
                                '<div class="alert alert-success align-items-center text-center" style="width:90%; border-radius: 6px;" role="alert">
                                    <div>   
                                        <h2><i class="fas fa-check-circle"></i>
                                        Amount Transfered Successfully!</h2>
                                    </div>
                                </div>
                            </div>';

                        $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'succeed')";
                        $sqltransact = mysqli_query($conn, $sqltran);
                        }
                        
                        else{
                            echo 
                                '<div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <div>
                                        <i class="fas fa-times-circle"></i>
                                        Oops! Something went wrong!
                                    </div>
                                </div>';
                        
                            $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'failed')";
                            $sqltransact = mysqli_query($conn, $sqltran);
                        }

                    }
                
                    else{
                        echo 
                            '<div class="alert alert-danger align-items-center text-center" style="width:90%; border-radius: 6px;" role="alert">
                                <div>   
                                    <h2><i class="fas fa-times-circle"></i>
                                    Not Sufficient Balance in Account!</h2></div>
                                </div>
                            </div>';
                        
                            $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'failed')";
                        $sqltransact = mysqli_query($conn, $sqltran);
                    }
                }
            }
        ?>

    </header>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>