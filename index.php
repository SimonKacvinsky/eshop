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
    <link rel="stylesheet" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Quicksand:wght@300..700&family=Signika:wght@300..700&display=swap"
          rel="stylesheet">
</head>
<body>
<div id="form_container">
    <form method="post" enctype="multipart/form-data">
        <label for="product_name">Názov produktu:</label><br>
        <input type="text" id="product_name" name="product_name"
               title="Zadajte názov produktu, ktorý sa zobrazí na webstránke" required><br>

        <label for="description">Popis:</label><br>
        <textarea id="description" name="description" title="Zadajte popis produktu, ktorý sa zobrazí na webstránke"
                  required></textarea><br>

        <label for="price">Cena:</label><br>
        <input type="text" id="price" name="price" title="Zadajte cenu produktu, ktorá sa zobrazí na webstránke"
               required><br>

        <label for="image">Hlavný obrázok:</label><br>
        <input type="file" id="image" name="image"
               title="Vyberte obrázok produktu, ktorý sa zobrazí na webstránke ako hlavný" required><br>

        <input type="submit" id="submit" value="Odoslať">
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

?>
<div style="display: flex;justify-content: center;">
    <div id="products_container">
        <?php
        $get_data = "SELECT * FROM products";
        $data = mysqli_query($conn, $get_data);
        $all_data = mysqli_fetch_all($data, MYSQLI_ASSOC);
        foreach ($all_data as $row) {
            $id = $row["id"];
            $name = $row["product_name"];
            $price = $row["price"];
            $description = $row["description"];
            $image = $row["main_image_path"];
            echo "
                <div class='product_container $id'>
                    <div class='product_wrapper'>
                        <img class='product_image' src='$image' alt='$name'>
                        <h3 class='product_name'>$name</h3>
                        <p class='product_description'>$description</p>
                        <div class='order_container'>
                            <div class='price_wrapper'>
                            <h3 class='product_price'>$price €</h3>
                            </div>
                            <div class='cart_wrapper'>
                                <svg class='cart' fill='#28b840' width='32px' viewBox='0 0 24.00 24.00' xmlns='http://www.w3.org/2000/svg' stroke='#28b840' stroke-width='0.00024000000000000003'>
                                    <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                                    <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                                    <g id='SVGRepo_iconCarrier'>
                                        <path d='M22,8.5H19.535l-3.7-5.555a1,1,0,0,0-1.664,1.11L17.132,8.5H6.868L9.832,4.055a1,1,0,0,0-1.664-1.11L4.465,8.5H2a1,1,0,0,0,0,2H3v8a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3v-8h1a1,1,0,0,0,0-2Zm-3,10a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v-8H19ZM7,17V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Zm4,0V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Zm4,0V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Z'></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        mysqli_close($conn);
        ?>
    </div>
    <div id="current_cart">
        <div style="width: 20vw; position: relative">
            <span style="width: 20vw">Počet produktov v košíku: <span id="number_of_products">0</span>
            <svg class='cart' fill='#28b840' width='32px' viewBox='0 0 24.00 24.00'
                 xmlns='http://www.w3.org/2000/svg'
                 stroke='#28b840' stroke-width='0.00024000000000000003'>
                    <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                    <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                    <g id='SVGRepo_iconCarrier'>
                        <path d='M22,8.5H19.535l-3.7-5.555a1,1,0,0,0-1.664,1.11L17.132,8.5H6.868L9.832,4.055a1,1,0,0,0-1.664-1.11L4.465,8.5H2a1,1,0,0,0,0,2H3v8a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3v-8h1a1,1,0,0,0,0-2Zm-3,10a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v-8H19ZM7,17V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Zm4,0V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Zm4,0V13a1,1,0,0,1,2,0v4a1,1,0,0,1-2,0Z'></path>
                    </g>
                </svg>
            </span>
        </div>
    </div>
</div>
<script src="js/app.js"></script>
</body>
</html>