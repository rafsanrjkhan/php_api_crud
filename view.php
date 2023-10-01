<!-- view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<body>

    <?php
    // Check if product ID is provided in the URL
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Fetch product details from the database
        $conn = new mysqli('localhost', 'root', '', 'php_api_crud');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM products WHERE id = $productId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            ?>
            <h2>Product Details</h2>
            <p><strong>ID:</strong> <?php echo $product['id']; ?></p>
            <p><strong>Name:</strong> <?php echo $product['product_name']; ?></p>
            <p><strong>Description:</strong> <?php echo $product['product_description']; ?></p>
            <p><strong>Price:</strong> <?php echo $product['product_price']; ?></p>
            <?php
        } else {
            echo "<p>No product found with ID: $productId</p>";
        }

        $conn->close();
    } else {
        echo "<p>Product ID not provided in the URL</p>";
    }
    ?>

</body>
</html>
