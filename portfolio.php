<?php
    include("connection.php");
    session_start();
    if (isset($_SESSION['email'])) {
        $uid = $_SESSION['user_id'];
        $username=$_SESSION['usern'];
        $role=$_SESSION['role'];
        if($role=="admin"){
            header("Location: dash.php");
            exit();
        }
        $sql="select * from portfolio where user_id='$uid'";
        $result = $conn->query($sql);
        if ($result) {
            
        } 
            // Use $username as needed 
        else {
            // User not founds
            echo "User not found.";
        }
        
        // Use the user information to personalize the dashboard
    } 
    else {
        // Redirect the user to the login page if not logged in
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
    <style>
        /* Add your custom styles here */
        button.btn a {
            color: azure;
        }

        /* Additional styles for improved design */
        .navbar-brand img {
            max-width: 40px;
            margin-right: 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .navbar-custom {
            background-color: #2c3e50; /* Custom background color */
        }

        .navbar-custom .navbar-brand {
            color: #ffffff; /* Navbar brand text color */
            font-weight: bold;
        }

        .navbar-custom .navbar-brand:hover {
            color: #f39c12; /* Hover color for navbar brand */
        }

        .navbar-custom .navbar-nav .nav-link {
            color: #ffffff; /* Navbar link text color */
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #f39c12; /* Hover color for navbar links */
        }

        .navbar-custom .form-inline .btn-danger {
            background-color: #e74c3c; /* Button background color */
            border-color: #e74c3c; /* Button border color */
        }

        .navbar-custom .form-inline .btn-danger:hover {
            background-color: #c0392b; /* Button hover background color */
            border-color: #c0392b; /* Button hover border color */
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl navbar-dark" style="background-color:rgb(18, 62, 105);">
        <div class="container-fluid">
            <a class="navbar-brand fw-normal text-center" href="#" onclick="window.location.href='dash.php'"><h4><?php echo $username; ?> Portfolio</h4></a>         
        </div>
        <form method="POST" action='logout.php'>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal" type="submit"
                        name="logout">Logout</button>
                </form>
    </nav>

    <!-- Page Content -->
    <div class="container mt-4">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="text-warning">Your Holdings</h1s>
    </div>

        <!-- Add New Transaction Button -->
        <div class="text-right mb-3">
            <a href="add_to_portfolio.php" class="btn btn-success">Add New Transaction</a>
        </div>

        <!-- Holdings Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Stock Symbol</th>
                        <th>Stock Name</th>
                        <th>Stock Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['STOCK_ID'] . "</td>";
                            $stock_id = $row['STOCK_ID'];
                            $sql_stc = "SELECT * FROM company WHERE stock_id = '$stock_id' ";
                            $res_stc = mysqli_query($conn, $sql_stc);
                            if ($res_stc) {
                                $stc_row = mysqli_fetch_assoc($res_stc);
                                echo "<td>" . $stc_row['STOCK_NAME'] . "</td>";
                            } else {
                                echo "<td>Stock Name Not Found</td>";
                            }
                            $p = $row['buy_price'];
                            $q = $row['quantity'];
                            $t = $p * $q;
                            echo "<td>" . $row['buy_price'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $t . "</td>";
                            echo "<td><button class='btn btn-primary' onclick=\"deleteRecord('" . $row['STOCK_ID'] . "')\">Sell</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='6' class='text-center'>No Data Added</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteRecord(stockId) {
            var stocksToSell = prompt("How many stocks do you want to sell?");

            if (stocksToSell !== null && stocksToSell !== "") {
                var confirmDelete = confirm("Are you sure you want to sell " + stocksToSell + " stocks?");

                if (confirmDelete) {
                    window.location.href = "del_portfolio.php?stock_id=" + stockId + "&stocks_to_sell=" + stocksToSell;
                }
            } else {
                alert("Please enter a valid number of stocks to sell.");
            }
        }
    </script>
    <center>
        <div id="myDivT" style="width:1000px; height:500px;"></div>
    </center>
    </body>


</html>