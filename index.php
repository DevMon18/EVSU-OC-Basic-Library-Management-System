<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
  <title>EVSU - LMS</title>
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

  <div id="alertuser"></div>

  <div class="container my-3 shadow">
    <h1><img src="evsulogo.png" alt=""> 
    EVSU - Library Management System
    </h1>
    <hr />
    <form id="mylibraryform" method="POST" action="">
      <div class="form-group">
        <label for="User-Name">FullName</label>
        <input type="text" class="form-control" id="User-Name" name="User-Name" aria-describedby="emailHelp" required />
        <small id="emailHelp" class="form-text text-muted">We'll never share your user name with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="Book-Name">Book Name</label>
        <input type="text" class="form-control" id="Book-Name" name="Book-Name" required />
      </div>
      <div class="form-group">
        <label for="bookType">Book Type</label>
        <select class="form-control" id="bookType" name="bookType" required>
          <option value="">Select a book type</option>
          <option value="Fiction">Fiction</option>
          <option value="Programming">Programming</option>
          <option value="Cooking">Cooking</option>
          <option value="Romance">Romance</option>
          <option value="Science">Science</option>
          <option value="History">History</option>
          <option value="Biography">Biography</option>
          <option value="Memoir">Memoir</option>
          <option value="Self-help">Self-help</option>
          <option value="Business">Business</option> 
          <option value="Finance">Finance</option>
          <option value="Art">Art</option>
          <option value="Music">Music</option>
          <option value="Sports">Sports</option>    
          <option value="Health">Health</option>
          <option value="Psychology">Psychology</option>
          <option value="Philosophy">Philosophy</option>
          <option value="Religion">Religion</option>
          <option value="Travel">Travel</option>
          <option value="Education">Education</option>
          <option value="Poetry">Poetry</option>

        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-outline-dark">Add Book</button>
    </form>
    <table class="table table-dark my-3" id="book-table">
      <thead>
        <tr>
          <th></th>
         <th></th>
         <th></th>
        <th></th>
        <th></th>
        <th class="d-flex justify-content-end">
                <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" id="searchInput" onkeyup="filterTable()" placeholder="Search" aria-label="Search" />
             
                </form>
        </th>
        </tr>
        <tr>
          <th scope="col">Sl No.</th>
          <th scope="col">Date of issue</th>
          <th scope="col">Reader</th>
          <th scope="col">Book Name</th>
          <th scope="col">Genre</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody id="table-body">
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['submit'])) {
    $fullName = $_POST['User-Name'];
    $bookName = $_POST['Book-Name'];
    $bookType = $_POST['bookType'];

    $sql = "INSERT INTO books (reader, book_name, genre) VALUES ('$fullName', '$bookName', '$bookType')";

    if ($conn->query($sql) === true) {
      // Redirect to prevent form resubmission on page refresh
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Delete book
if (isset($_GET['delete'])) {
  $deleteId = $_GET['delete'];
  $deleteSql = "DELETE FROM books WHERE id = $deleteId";

  if ($conn->query($deleteSql) === true) {
    // Redirect to prevent resubmission of delete action on page refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}

// Display existing books from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $counter = 1;
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $counter . "</td>";
    echo "<td>" . $row['date_of_issue'] . "</td>";
    echo "<td>" . $row['reader'] . "</td>";
    echo "<td>" . $row['book_name'] . "</td>";
    echo "<td>" . $row['genre'] . "</td>";
    echo "<td class=\"text-right\">";
    echo "<a href=\"edit.php?id=" . $row['id'] . "\" class=\"btn btn-primary btn-sm\">Edit</a> ";
    echo "<a href=\"{$_SERVER['PHP_SELF']}?delete=" . $row['id'] . "\" class=\"btn btn-danger btn-sm\">Delete</a>";
    echo "</td>";
    echo "</tr>";
    $counter++;
  }
} else {
  echo "<tr><td colspan='6'>No books found</td></tr>";
}

$conn->close();
?>
      </tbody>
    </table>
  </div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script>
    function filterTable() {
  // Get the input value and convert it to lowercase
  var input = document.getElementById("searchInput").value.toLowerCase();
  
  // Get all the table rows
  var rows = document.getElementById("table-body").getElementsByTagName("tr");
  
  // Loop through the rows and hide those that don't match the search query
  for (var i = 0; i < rows.length; i++) {
    var rowData = rows[i].getElementsByTagName("td");
    var matched = false;
    
    // Check if any of the row's columns match the search query
    for (var j = 0; j < rowData.length; j++) {
      var columnData = rowData[j].textContent.toLowerCase();
      
      // Show the row if any column matches the search query
      if (columnData.indexOf(input) > -1) {
        matched = true;
        break;
      }
    }
    
    // Toggle the row visibility based on the match
    rows[i].style.display = matched ? "" : "none";
  }
}
</script>
</body>
</html>