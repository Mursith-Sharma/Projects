<?php 
session_start(); 

$name = $email = $contact = $dob = $occup = $nic = $gender = "";
$nameerr = $emailerr = $contacterr = $doberr = $nicerr = $occuperr = $gendererr = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameerr = "*Name is required";
  } else {
    $name = text_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      $nameerr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailerr = "*Email is required";
  } else {
    $email = text_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailerr = "Invalid email format";
    }
  }

  if (empty($_POST["mobile"])) {
    $contacterr = "*Contact number is required";
  } else {
    $contact = text_input($_POST["mobile"]);
    if (!preg_match("/^(\+?\d{1,4}[\s-]?)?\d{10}$/", $contact)) {
      $contacterr = "Invalid contact number";
    }
  }

  if (empty($_POST["nic"])) {
    $nicerr = "*NIC number is required";
  } else {
    $nic = text_input($_POST["nic"]);
    if (!preg_match("/^\d{12}$/", $nic)) {
      $nicerr = "NIC number must be exactly 12 digits.";
    }
  }

  if (empty($_POST["dob"])) {
    $doberr = "*Date of Birth is required";
  } else {
    $dob = text_input($_POST["dob"]);
  }

  if (empty($_POST["occupation"])) {
    $occuperr = "*Occupation is required";
  } else {
    $occup = text_input($_POST["occupation"]);
  }

  if (empty($_POST["gender"])) {
    $gendererr = "*Gender is required";
  } else {
    $gender = text_input($_POST["gender"]);
  }

  if (
    empty($nameerr) && empty($emailerr) && empty($contacterr) &&
    empty($doberr) && empty($nicerr) && empty($occuperr) && empty($gendererr)
  ) {
    include("database.php");
    $conn = Database::getconnection();

    $address = ""; // placeholder for now (you can add this as a form field later)

    $stmt = $conn->prepare("INSERT INTO resident (full_name, dob, nic, address, phone, email, occupation, gender, registered_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssssss", $name, $dob, $nic, $address, $contact, $email, $occup, $gender);

    if ($stmt->execute()) {
      $success = "✅ Registration successful!";
      $name = $email = $contact = $dob = $occup = $nic = $gender = "";
    } else {
      $success = "❌ Registration failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  }
}

function text_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .error { color: red; }
    .H1 {
      text-align: center;
      text-transform: uppercase;
      font-weight: bold;
      font-size: 50px;
      padding: 15px;
      margin-top: 20px;
      color: #000;
    }
    .mma { background-color: rgb(211, 181, 9); }
    .container {
      background-color: #e3f2fd;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 11px 7px rgba(0,0,0,0.75);
    }
  </style>
</head>
<body class="mma">
  <h1 class="H1">Registration Form</h1>

  <div class="container mt-4">
    <?php if (!empty($success)): ?>
      <div class="alert alert-success text-center">
        <?php echo $success; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <span class="error"><?php echo $nameerr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <span class="error"><?php echo $emailerr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control" name="mobile" value="<?php echo htmlspecialchars($contact); ?>">
        <span class="error"><?php echo $contacterr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">NIC Number</label>
        <input type="text" class="form-control" name="nic" value="<?php echo htmlspecialchars($nic); ?>">
        <span class="error"><?php echo $nicerr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" class="form-control" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
        <span class="error"><?php echo $doberr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Occupation</label>
        <input type="text" class="form-control" name="occupation" value="<?php echo htmlspecialchars($occup); ?>">
        <span class="error"><?php echo $occuperr; ?></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label><br>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>> Male
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>> Female
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" name="gender" value="Other" <?php if($gender=="Other") echo "checked"; ?>> Other
        </div>
        <br>
        <span class="error"><?php echo $gendererr; ?></span>
      </div>

      <button type="submit" class="btn btn-primary d-grid gap-2 col-6 mx-auto">Submit</button>
    </form>

    <br><br>
    <div class="text-center">
      <a href="index.html" class="btn btn-outline-dark btn-lg">Go To Home</a>
    </div>
  </div>
</body>
</html>
