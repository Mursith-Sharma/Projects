<?php
session_start(); // ✅ Session Start
if (isset($_SESSION['delete_success'])) {
    echo "<div class='alert alert-success text-center'>" . $_SESSION['delete_success'] . "</div>";
    unset($_SESSION['delete_success']);
}
if (isset($_SESSION['delete_error'])) {
    echo "<div class='alert alert-danger text-center'>" . $_SESSION['delete_error'] . "</div>";
    unset($_SESSION['delete_error']);
}

if (isset($_SESSION['update_success'])) {
    echo "<div class='alert alert-success text-center'>" . $_SESSION['update_success'] . "</div>";
    unset($_SESSION['update_success']);
}
if (isset($_SESSION['update_error'])) {
    echo "<div class='alert alert-danger text-center'>" . $_SESSION['update_error'] . "</div>";
    unset($_SESSION['update_error']);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

ob_start(); // unwanted echo suppress
include("database.php");
$connection = Database::getconnection();
ob_end_clean(); // discard echo from database.php

$name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
$nic = isset($_POST['NIC']) ? trim($_POST['NIC']) : '';
$address = isset($_POST['addr']) ? trim($_POST['addr']) : '';

// Dynamic WHERE condition
$conditions = [];

if (!empty($name)) {
    $conditions[] = "full_name = '$name'";
}
if (!empty($nic)) {
    $conditions[] = "nic = '$nic'";
}
if (!empty($address)) {
    $conditions[] = "address = '$address'";
}

if (empty($conditions)) {
    $sql = "SELECT * FROM resident WHERE 1=0";
} else {
    $sql = "SELECT * FROM resident WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($connection, $sql);
?>

<!--//////////////////////////////////////////////////////////////////////////////////////////////////-->

<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="body1">
  <div class="container-fluid">
    <h2 class="head-title1">🔍 Search Results</h2>

    <!-- ✅ Success or error message -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-success text-center'>".$_SESSION['message']."</div>";
        unset($_SESSION['message']);
    }
    ?>

    <div class="results-table1">
      <?php
      if (mysqli_num_rows($result) > 0) {
          echo "<table class='table table-bordered table-striped'>";
          echo "<thead class='table-dark'><tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>DOB</th>
                  <th>NIC</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Occupation</th>
                  <th>Gender</th>
                  <th>Registered Date</th>
                  <th>Changes</th>
                </tr></thead><tbody>";

          while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>".$row['id']."</td>
                      <td>".$row['full_name']."</td>
                      <td>".$row['dob']."</td>
                      <td>".$row['nic']."</td>
                      <td>".$row['address']."</td>
                      <td>".$row['phone']."</td>
                      <td>".$row['email']."</td>
                      <td>".$row['occupation']."</td>
                      <td>".$row['gender']."</td>
                      <td>".$row['registered_date']."</td>
                      <td>
                        <a href='modify.php?id=".$row['id']."' class='btn btn-warning btn-sm'>Modify</a>
                        <a href='delete.php?id=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                      </td>
                    </tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<p class='text-danger text-center'>No matching records found.</p>";
      }

      mysqli_close($connection);
      ?>
    </div>
  </div>
</body>
</html>
