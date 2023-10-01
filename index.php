<!-- index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
</head>

<body>

    <h2>Add Product</h2>
    <form method="post" action="process.php">
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" required>

        <label for="productDescription">Product Description:</label>
        <textarea name="productDescription" required></textarea>

        <label for="productPrice">Product Price:</label>
        <input type="number" name="productPrice" step="0.01" required>

        <button type="submit">Add Product</button>
    </form>

    <h2>Product List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display data in the table
            $conn = new mysqli('localhost', 'root', '', 'php_api_crud');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['product_name']}</td>";
                    echo "<td>{$row['product_description']}</td>";
                    echo "<td>{$row['product_price']}</td>";
                    echo "<td>
                                <a href='view.php?id={$row['id']}'>View</a>
                                <button onclick='editProduct({$row['id']})'>Edit</button>
                                <button onclick='deleteProduct({$row['id']})'>Delete</button>
                                </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

</body>

</html>