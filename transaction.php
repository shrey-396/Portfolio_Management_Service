<?php
    include("connection.php");
    session_start();
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $role=$_SESSION['role'];
        if($role=="admin"){
            header("Location: dash.php");
            exit();
        }
        //echo $user_id;
        $sql_userid = "SELECT * FROM transaction where user_id_purchased='$user_id' or user_id_bought='$user_id' ";
        $result = mysqli_query($conn, $sql_userid);
        if ($result) {
            // if (mysqli_num_rows($result) > 0) {
            //     // while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            //     //     // Access and display individual data from $row
            //     //     echo "Other Data: " . $row['STOCK_ID'] . "<br>";
            //     //     echo "Item Name: " . $row['STOCK_PRICE'] . "<br>";
            //     // }
            // } else {
            //     header("Location: dash.php"); // Redirect to the index page if no rows found
            //     exit();
            // }
        } else {
            // Handle database query error
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
    <style>
        body {
            padding-top: 60px;
        }

        .navbar {
            background-color: rgb(18, 62, 105);
        }

        .btn-custom {
            color: black;
        }

        .table-responsive {
            margin: 20px auto;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dash.php">Transactions</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Symbol..."
                        aria-label="Search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h2>Transaction Details</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="make_transac.php" class="btn btn-primary">+ Add New</a>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Stock ID</th>
                                <th>Date of Purchase</th>
                                <th>Purchased By</th>
                                <th>Sold By</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTable">
                            <?php
                            if(mysqli_num_rows($result) > 0){
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['TRANSACTION_ID'] . "</td>";
                                    echo "<td>" . $row['STOCK_ID'] . "</td>";
                                    echo "<td>" . $row['DATE_OF_PURCHASE'] . "</td>";
                                    echo "<td>" . $row['USER_ID_PURCHASED'] . "</td>";
                                    echo "<td>" . $row['USER_ID_BOUGHT'] . "</td>";
                                    echo "<td>" . $row['QUANTITY'] . "</td>";
                                    echo "<td>$" . number_format($row['PRICE'], 2) . "</td>"; // Format price as currency
                                    $total_price = $row['QUANTITY'] * $row['PRICE'];
                                    echo "<td>$" . number_format($total_price, 2) . "</td>"; // Format total price as currency
                                    echo "</tr>";
                                }
                            }
                            else{
                                echo "<tr>";
                                echo "<td colspan='8'>No Transactions Made</td>"; // Span the entire row if no transactions
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for filtering table rows -->
    <script>
        $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#transactionTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>

</html>
