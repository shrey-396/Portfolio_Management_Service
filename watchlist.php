
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
        $sql_userid = "SELECT * FROM watchlist WHERE user_id = '$user_id'";
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
    <title>Watchlist</title>

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
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dash.php">Watchlist</a>
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

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-6">
                <h2>Items</h2>
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-success btn-custom" href="add_to_watch.php">+ Add New</a>
            </div>
        </div>

        <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Symbol</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Current Price</th>
                        <th scope="col">Action</th>
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
                            echo "<td>" . $row['STOCK_PRICE'] . "</td>";
                            echo "<td><button class='btn btn-sm btn-danger' onclick=\"deleteRecord('" . $row['STOCK_ID'] . "')\">Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='4'>No Data Added</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script>
        function deleteRecord(stockId) {
            if (confirm('Are you sure you want to delete this record?')) {
                window.location.href = "del_watch.php?stock_id=" + stockId;
            }
        }
    </script>
</body>


</html>
