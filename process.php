<?php
$conn = new mysqli('localhost', 'root', '', 'php_api_crud');

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required form data is set
    if (isset($_POST['productName']) && isset($_POST['productDescription']) && isset($_POST['productPrice'])) {
        // Sanitize form data
        $productName = sanitizeInput($_POST['productName']);
        $productDescription = sanitizeInput($_POST['productDescription']);
        $productPrice = sanitizeInput($_POST['productPrice']);

        // Create the SQL query
        $sql = "INSERT INTO products (product_name, product_description, product_price) VALUES ('$productName', '$productDescription', '$productPrice')";

        // Output JSON response for POST request
        header('Content-Type: application/json');
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Product added successfully']);
        } else {
            echo json_encode(['error' => 'Error adding product']);
        }
    } else {
        echo json_encode(['error' => 'Incomplete data for product addition']);
    }

    $conn->close();
}
// Check if the request is a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch and display data in the table
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode(['products' => $products]);
    } else {
        echo json_encode(['message' => 'No products found']);
    }

    $conn->close();
}

// Check if the request is a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse the raw data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Ensure that the 'id' parameter is set
    if (isset($data->id)) {
        $productId = sanitizeInput($data->id);

        // Delete the product from the database
        $deleteSql = "DELETE FROM products WHERE id = $productId";

        header('Content-Type: application/json');
        if ($conn->query($deleteSql) === TRUE) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['error' => 'Error deleting product']);
        }
    } else {
        echo json_encode(['error' => 'Product ID is missing']);
    }

    $conn->close();
}

// Check if the request is a PUT or PATCH request
if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    // Parse the raw data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Ensure that the required parameters are set
    if (isset($data->id) && isset($data->productName) && isset($data->productDescription) && isset($data->productPrice)) {
        $productId = sanitizeInput($data->id);
        $productName = sanitizeInput($data->productName);
        $productDescription = sanitizeInput($data->productDescription);
        $productPrice = sanitizeInput($data->productPrice);

        // Update the product in the database
        $updateSql = "UPDATE products SET 
                      product_name = '$productName', 
                      product_description = '$productDescription', 
                      product_price = '$productPrice' 
                      WHERE id = $productId";

        header('Content-Type: application/json');
        if ($conn->query($updateSql) === TRUE) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            echo json_encode(['error' => 'Error updating product']);
        }
    } else {
        echo json_encode(['error' => 'Incomplete data for product update']);
    }

    $conn->close();
}


?>
