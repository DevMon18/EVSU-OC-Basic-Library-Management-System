<html>
<head>
    <title>Edit Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
        /* Add custom styles */
        body {
            background-color: #461220;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        img{
            float:left;
            width:70px;
            height: 70px;
        }
    </style>
<body>
    <?php
    // Establish a connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "librarydb";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted for updating the book
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['submit'])) {
            $bookId = $_POST['bookId'];
            $fullName = $_POST['User-Name'];
            $bookName = $_POST['Book-Name'];
            $bookType = $_POST['bookType'];

            $updateSql = "UPDATE books SET reader='$fullName', book_name='$bookName', genre='$bookType' WHERE id='$bookId'";

            if ($conn->query($updateSql) === true) {
                // Redirect to the main page after successful update
                header("Location: index.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }

    // Retrieve the book data based on the provided ID
    if (isset($_GET['id'])) {
        $bookId = $_GET['id'];

        $sql = "SELECT * FROM books WHERE id='$bookId'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Display the edit form with pre-filled data
            ?>
          <div class="container mt-5 w-50 shadow">
                <h1><img src="evsulogo.png" alt=""> Edit Book</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="bookId" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="User-Name">Reader:</label>
                        <input type="text" class="form-control" name="User-Name" value="<?php echo $row['reader']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Book-Name">Book Name:</label>
                        <input type="text" class="form-control" name="Book-Name" value="<?php echo $row['book_name']; ?>">
                    </div>
                    <div class="form-group">
    <label for="bookType">Genre:</label>
    <select class="form-control" id="bookType" name="bookType" required>
        <option value="">Select a genre</option>
        <option value="Fiction"<?php echo ($row['genre'] === 'Fiction') ? ' selected' : ''; ?>>Fiction</option>
        <option value="Programming"<?php echo ($row['genre'] === 'Programming') ? ' selected' : ''; ?>>Programming</option>
        <option value="Cooking"<?php echo ($row['genre'] === 'Cooking') ? ' selected' : ''; ?>>Cooking</option>
    </select>
</div>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <?php
        } else {
            echo "Book not found";
        }
    } else {
        echo "Invalid request";
    }

    $conn->close();
    ?>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>