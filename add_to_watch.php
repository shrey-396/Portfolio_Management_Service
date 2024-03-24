<?php
    include("connection.php");
    session_start();
    if (isset($_SESSION['email'])) {
        $uid = $_SESSION['user_id'];
    } 
    else {
        // Redirect the user to the login page if not logged in
        header("Location: dash.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Watchlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/style.css">
    <link rel="stylesheet" href="../static/font-awesome/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #ffcc00;
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 100%;
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
        }
        .btn-back:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>Add Transaction</h1>
        
        <form method="POST" action="add_tw.php">
            <div class="form-group">
                <label for="symbol">Company Symbol</label>
                <select class="form-control" id="symbol" name="symbol">
                    <?php
                    // Include your database connection here

                    // Query to fetch company symbols
                    $sql = "SELECT * FROM company";
                    $result = mysqli_query($conn, $sql);

                    // Check if query was successful
                    if ($result) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $companyName = $row['STOCK_ID'];
                            echo "<option value=\"$companyName\">$companyName</option>";
                        }

                        // Free the result set
                        mysqli_free_result($result);
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-submit" name="sub_tw">Submit</button>
        </form>

        <a href="watchlist.php" class="btn-back">Go back!</a>
    </div>

    <!-- Bootstrap JS and other scripts can be included here -->
</body>
</html>

