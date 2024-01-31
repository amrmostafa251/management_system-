<?php
session_start();
if ($_SESSION['user_name'] !== 'alsafa') {
    header("Location: homepage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "connection.php"; // Include your PDO database connection

    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $type = $_POST["type"];
    $countnumber = $_POST["countnumber"];
    
    try {
        $netSales = 0;
        for ($i = 1; $i <= $countnumber; $i++) {
            $item_name = $_POST["item_name"][$i - 1];
            $item_price = $_POST["sale_price"][$i - 1];
            $number = $_POST["number"][$i - 1];

            if ($type == "sales") {
                $clientSelect=$_POST["clientSelect"][0];
                echo $clientSelect."<br>";
                if ( $clientSelect=="client"){
                    $client_name = $_POST["client_name"][0];
                    echo $client_name."<br>";
                    $invoiceNumber = $_POST["invoiceNumber"][0];
                    echo $invoiceNumber."<br>";
                    $total_price = $_POST["total_price"][$i - 1] ;
                    echo $total_price."<br>";
                    //   store data in table invoice 
                    $stmt = $conn-> prepare("INSERT INTO invoice (client_name, invoice_number,year , month, day , item_name , number , sale_price , total_price) VALUES (?, ?, ?, ?, ?, ?,?,?,?) "  );
                    $stmt-> execute( [$client_name,$invoiceNumber,$year,$month, $day,$item_name,$number,$item_price, $total_price]);
                    // Store data in the sales table
                    $stmt = $conn->prepare("INSERT INTO sales (item_name, number, year, month, day, sale_price) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$item_name,$number, $year, $month, $day, $item_price]);
                    // select number from table exist 
                    $selectnum = $conn->prepare("SELECT number FROM exist WHERE item_name = ?");
                    $selectnum->execute([$item_name]);
                    $row = $selectnum->fetch(PDO::FETCH_ASSOC);
                    $updatenum = $row['number'] - $number;
                    
                    // Update the number in the existing table for the item
                    $stmtUpdateNumber = $conn->prepare("UPDATE exist SET number = ? WHERE item_name = ?");
                    $stmtUpdateNumber->execute([$updatenum,$item_name]);
                    // store data in table invoice summary                     
                }
                elseif ($clientSelect== "personal"){
                    // Store data in the sales table
                    $stmt = $conn->prepare("INSERT INTO sales (item_name, number, year, month, day, sale_price) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$item_name,$number, $year, $month, $day, $item_price]);
                    // select number from table exist 
                    $selectnum = $conn->prepare("SELECT number FROM exist WHERE item_name = ?");
                    $selectnum->execute([$item_name]);
                    $row = $selectnum->fetch(PDO::FETCH_ASSOC);
                    $updatenum = $row['number'] - $number;
                    
                    // Update the number in the existing table for the item
                    $stmtUpdateNumber = $conn->prepare("UPDATE exist SET number = ? WHERE item_name = ?");
                    $stmtUpdateNumber->execute([$updatenum,$item_name]);
                    // store data in table invoice                
                }
           
            } elseif ($type == "purchases") {
                $purchase_price = $_POST["purchase_price"][$i - 1];
                $sale_price_client = $_POST["sale_price_client"][$i -1];
                // Store data in the purchases table
                $stmt = $conn->prepare("INSERT INTO purchases (item_name, number, price, sale_price, year, month, day) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$item_name, $number , $purchase_price, $item_price, $year, $month, $day]);
                
                //store client sale price in its table
                $stmt = $conn->prepare("UPDATE  client_sales set client_sale_price =? WHERE Item_name = ?  ");
                $stmt->execute([$sale_price_client, $item_name]);
                // Update the items table
                $stmtUpdateItems = $conn->prepare("UPDATE items SET sale_price = ?, price = ? WHERE item_name = ?");
                $stmtUpdateItems->execute([$item_price, $purchase_price, $item_name]);
                // select number from table exist 
                $selectnum = $conn->prepare("SELECT number FROM exist WHERE item_name = ?");
                $selectnum->execute([$item_name]);
                $row = $selectnum->fetch(PDO::FETCH_ASSOC); 
                $updatenum = $row['number'];
                $number += $updatenum; 
                // Update the number in the existing table for the item
                $stmtUpdateNumber = $conn->prepare("UPDATE exist SET number = ? WHERE item_name = ?");
                $stmtUpdateNumber->execute([$number,$item_name]);
                // updat sale price in table exist 
                $sql = "UPDATE exist SET sale_price = ? WHERE item_name = ?";
                $newstm = $conn->prepare($sql);
                $newstm->execute([$item_price, $item_name]);
            }

        }
        if ($type == "sales"){
            $clientSelect=$_POST["clientSelect"][0];
            echo $clientSelect."<br>";
            $client_name = $_POST["client_name"][0];
            echo $client_name."<br>";
            $invoiceNumber = $_POST["invoiceNumber"][0];
            echo $invoiceNumber."<br>";
            if ( $clientSelect =="client"){
                for ($i = 1; $i <= $countnumber; $i++) {
                    $total_price = $_POST["total_price"][$i - 1] ;
                    $netSales +=  $total_price;
                    echo $netSales."<br>";
                }
                $stmt = $conn->prepare("INSERT INTO invoices_summary (client_name , invoice_number, net_sales) VALUES (?,?,?)");
                $stmt->execute([$client_name ,$invoiceNumber ,$netSales]);
            }

        }
        // Display an alert and redirect to homepage.php using JavaScript
        echo '<script>alert("تم إضافة المنتجات بنجاح "); window.location.href = "new_invoice.php";</script>';

    } catch (PDOException $e) {
        echo "Error: " ;
    }
}
?>
