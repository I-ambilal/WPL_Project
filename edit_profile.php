<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("❌ Not logged in.");
}

$conn = new mysqli("localhost", "root", "", "evil_db");
if ($conn->connect_error) {
    die("❌ DB connection failed: " . $conn->connect_error);
}

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("❌ User not found.");
}

$user = $res->fetch_assoc();

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$csrf_token = $_SESSION['csrf_token'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }

    .container {
      background: #fff;
      margin-top: 50px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    img {
      max-width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      display: block;
      margin: 0 auto 15px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #1877f2;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #165ec9;
    }
    .back-btn {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #fff;
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 14px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
      z-index: 10;
    }.back-btn {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #fff;
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 14px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
      z-index: 10;
    }.back-btn {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #fff;
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 14px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
      z-index: 10;
    }
  </style>
</head>
<body>
  <div class="container">
     <a href="new22.php" class="back-btn">← Back</a>
    <h2>Edit Profile</h2>
    <form action="auth_handler.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="update_profile" />
      <input type="hidden" name="csrf_token" value="<?= e($csrf_token) ?>" />

      <img src="uploads/<?= e($user['profile_picture']) ?>" alt="Profile Picture" />

      <label>First Name</label>
      <input type="text" name="first_name" value="<?= e($user['first_name']) ?>" required />

      <label>Last Name</label>
      <input type="text" name="last_name" value="<?= e($user['last_name']) ?>" required />

      <label>Email</label>
      <input type="email" name="email" value="<?= e($user['email']) ?>" required />

      <label>Age</label>
      <input type="number" name="age" value="<?= (int)$user['age'] ?>" min="0" max="120" required />

      <label>Change Password</label>
      <input type="password" name="new_password" placeholder="Leave blank to keep old password" />

      <label>Change Profile Picture</label>
      <input type="file" name="profile_picture" accept="image/*" />

      <button type="submit">Save Changes</button>
    </form>
  </div>
</body>
</html>
