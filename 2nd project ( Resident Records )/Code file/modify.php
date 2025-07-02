<?php
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['update_error'] = "No ID provided.";
    header("Location: search.php");
    exit();
}

include("database.php");
$connection = Database::getconnection();

$id = intval($_GET['id']);

// Fetch existing data
$sql = "SELECT * FROM resident WHERE id = $id";
$result = mysqli_query($connection, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['update_error'] = "No record found for update.";
    header("Location: search.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// Initialize update message
$update_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $dob = $_POST['dob'];
    $nic = trim($_POST['nic']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $occupation = trim($_POST['occupation']);
    $gender = $_POST['gender'];

    $stmt = $connection->prepare("UPDATE resident SET full_name=?, dob=?, nic=?, address=?, phone=?, email=?, occupation=?, gender=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $full_name, $dob, $nic, $address, $phone, $email, $occupation, $gender, $id);

    if ($stmt->execute()) {
        $update_msg = "✅ Record updated successfully.";
        // Refresh $row with updated values for display
        $row = [
            'full_name' => $full_name,
            'dob' => $dob,
            'nic' => $nic,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'occupation' => $occupation,
            'gender' => $gender
        ];
    } else {
        $update_msg = "❌ Update failed: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Resident</h2>

    <?php if (!empty($update_msg)) : ?>
        <div class="alert alert-<?php echo str_starts_with($update_msg, '✅') ? 'success' : 'danger'; ?> text-center">
            <?php echo $update_msg; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($row['full_name']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="<?php echo $row['dob']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">NIC</label>
            <input type="text" name="nic" class="form-control" value="<?php echo htmlspecialchars($row['nic']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($row['address']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($row['phone']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Occupation</label>
            <input type="text" name="occupation" class="form-control" value="<?php echo htmlspecialchars($row['occupation']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="Male" class="form-check-input" <?php if ($row['gender'] == 'Male') echo "checked"; ?>> Male
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="Female" class="form-check-input" <?php if ($row['gender'] == 'Female') echo "checked"; ?>> Female
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="Other" class="form-check-input" <?php if ($row['gender'] == 'Other') echo "checked"; ?>> Other
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="search.php" class="btn btn-secondary">Back to Search</a>
        <a href="index.html" class="btn btn-outline-dark">Go To Home</a>
    </form>
</div>
</body>
</html>
