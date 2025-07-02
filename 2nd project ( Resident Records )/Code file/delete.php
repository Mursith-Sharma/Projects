<?php
session_start(); // Start session
include("database.php");
$connection = Database::getconnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = "DELETE FROM resident WHERE id = $id";
    if (mysqli_query($connection, $delete)) {
        $_SESSION['delete_success'] = "✅ Record deleted successfully.";
        header("Location: search_result.php");
        exit;
    } else {
        $_SESSION['delete_error'] = "❌ Delete failed.";
        header("Location: search_result.php");
        exit;
    }
} else {
    $_SESSION['delete_error'] = "⚠️ Invalid ID.";
    header("Location: search_result.php");
    exit;
}
