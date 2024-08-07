<?php
require 'config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="form_container">
    <form method="post" enctype="multipart/form-data">
        <label for="product_name">Názov produktu:</label><br>
        <input type="text" id="product_name" name="product_name" required><br>

        <label for="description">Popis:</label><br>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Cena:</label><br>
        <input type="text" id="price" name="price" required><br>

        <label for="image">Hlavný obrázok:</label><br>
        <input type="file" id="image" name="image" required><br>

        <input type="submit" value="Odoslať">
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_FILES['image'])) {
        $name = $_POST['product_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Spracovanie nahratého súboru
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Overenie typu súboru (povolené formáty: jpg, png, jpeg, gif)
        $allowed_types = array("jpg", "png", "jpeg", "gif");
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;

                // Vkladanie produktu do databázy
                $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, main_image_path) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssds", $name, $description, $price, $image);

                if ($stmt->execute()) {
                    echo "Produkt bol úspešne pridaný.";
                } else {
                    echo "Chyba: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Chyba pri nahrávaní súboru.";
                exit();
            }
        } else {
            echo "Nepovolený formát súboru.";
            exit();
        }
    } else {
        echo "Prosím, vyplňte všetky polia.";
    }
}

$conn->close();
?>
</body>
</html>