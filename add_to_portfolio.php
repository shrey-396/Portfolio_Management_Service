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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Transaction</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    .container {
        width: 50%;
        margin: 5% auto;
        background-color: #fff;
        padding: 2.5rem;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-submit {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    #currentPrice {
        font-weight: bold;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Add Transaction</h1>
        <form method="POST" action="add_t.php">
            <div class="form-group">
                <label for="symbol">Symbol</label>
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
                    mysqli_close($conn);
                    ?>
                </select>
            </div>
            <div class="form-group">
                Current Price: <span id="currentPrice"></span>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" class="price-input" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
            </div>
            <div class="form-group">
                <center><input type="submit" class="btn-submit" name="sub_t" value="Submit"></center>
            </div>
        </form>
        <div>
            <center><h3><a href="#" onclick="window.location.href='dash.php'">Go back!</a></h3></center>
        </div>
    </div>

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
