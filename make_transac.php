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
        h1 {
            color: rgb(255, 204, 0);
        }
        a:hover {
            color: cyan;
        }
        select, input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form {
            color: rgb(78, 211, 255);
        }
        main {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .center {
            text-align: center;
        }
        .btn-submit {
            background-color: rgb(78, 211, 255);
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: rgb(54, 171, 204);
        }
    </style>
</head>
<body>
    <header class="center">
        <h1>Add Transaction</h1>
    </header>
    <main>
        <form method="POST" action='make_trans_p2.php'>
            <label for="symbol">Company Symbol</label>
            <select name="symbol" id="symbol" onchange="getSymbolCurrentPrice()">
                <?php
                    $sql = "SELECT * FROM company";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $companyName = $row['STOCK_ID'];
                            echo "<option value=\"$companyName\">$companyName</option>";
                        }
                        mysqli_free_result($result);
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>
            </select>
            <br><br>
            Current Price: <span id="currentPrice"></span>
            <br><br>
            Transaction Date: <input type="date" name='transaction_date' required>
            <br><br>
            Quantity: <input type="number" name="quantity" id="quantity" min="1" required>
            <br><br>
            Price: <input type="number" name="price" id="price" min="0" step="0.01" required>
            <br><br>
            Type: 
            <select name='type'>
                <option value="bought">Bought</option>
                <option value="sold">Sold</option>
            </select>
            <br><br>
            User ID:
            <select name="uid">
                <?php
                    $sql = "SELECT * FROM user_details WHERE user_id != '$uid'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $companyName = $row['user_id'];
                            echo "<option value=\"$companyName\">$companyName</option>";
                        }
                        mysqli_free_result($result);
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                ?>
            </select>
            <br><br>
            <div class="center">
                <input type="submit" class="btn-submit" name="sub_tt" value="Submit">
            </div>
        </form>
    </main>
    <footer class="center">
        <h3><a href="#" onclick="window.location.href='watchlist.php'">Go back!</a></h3>
    </footer>

    <script>
        function getSymbolCurrentPrice() {
            var symbol = document.getElementById('symbol').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_current_price.php?symbol=' + symbol, true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    var currentPriceSpan = document.getElementById('currentPrice');
                    currentPriceSpan.textContent = xhr.responseText;
                    currentPriceSpan.style.color = 'black';
                } else {
                    console.error('Request failed. Status: ' + xhr.status);
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
