<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>
<body>
    <h2>Insert Data into Advice Table</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="4" required></textarea><br><br>

        <label for="advice_image">Image:</label><br>
        <input type="file" name="advice_image" id="advice_image" accept="image/*" required><br><br>

        <button type="submit" name="submit">Insert</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Database connection
        $conn = new mysqli("localhost", "root", "", "advice");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);

        // Handle image upload
        $image = $_FILES['advice_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if not exists
        }

        if (move_uploaded_file($_FILES['advice_image']['tmp_name'], $target_file)) {
            // Insert data into database
            $sql = "INSERT INTO advice (title, description, advice_image) VALUES ('$title', '$description', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload image.";
        }

        $conn->close();
    }
    ?>
</body>
</html>
