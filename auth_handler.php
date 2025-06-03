<?php
session_start();

// Generate CSRF token if not present
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('❌ Invalid CSRF token.');
    }
}

// DB connection
$conn = new mysqli("localhost", "root", "", "evil_db");
if ($conn->connect_error) {
    die("❌ Database connection error: " . $conn->connect_error);
}

$action = $_POST['action'] ?? '';

function validateImageUpload($file) {
    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxSize = 2 * 1024 * 1024; // 2MB max

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "❌ File upload error.";
    }
    if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
        return "❌ Only JPG and PNG images are allowed.";
    }
    if ($file['size'] > $maxSize) {
        return "❌ File too large. Max 2MB allowed.";
    }
    $imgInfo = getimagesize($file['tmp_name']);
    if ($imgInfo === false) {
        return "❌ Uploaded file is not a valid image.";
    }
    return null;
}

if ($action === 'register') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $age = (int)($_POST['age'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$first || !$last || !$gender || !$age || !$email || !$password) {
        die("❌ Please fill all required fields.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email address.");
    }

    $imgError = validateImageUpload($_FILES['profile_picture']);
    if ($imgError) {
        die($imgError);
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("❌ Email is already registered.");
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $target = "uploads/" . uniqid('profile_', true) . "." . $ext;

    // Move the uploaded file to target location BEFORE DB insert
    if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
        die("❌ Failed to upload profile picture.");
    }

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, gender, age, email, password, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $first, $last, $gender, $age, $email, $passwordHash, $target);

    if ($stmt->execute()) {
        header("Location: new_login.html?registered=1");
        exit;
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    exit;
}

if ($action === 'login') {
    $email = trim($_POST['login_email'] ?? '');
    $pass = $_POST['login_password'] ?? '';

    if (!$email || !$pass) {
        die("❌ Please enter email and password.");
    }

    $stmt = $conn->prepare("SELECT id, first_name, email, password, profile_picture FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($pass, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            // Make sure the profile_picture is set, else fallback
            $_SESSION['profile_picture'] = !empty($user['profile_picture']) && file_exists($user['profile_picture']) ? $user['profile_picture'] : '11.jpeg';

            header("Location: new22.php");
            exit;
        } else {
            echo "❌ Wrong password.";
        }
    } else {
        echo "❌ No user found.";
    }
    exit;
}

// Update profile remains mostly the same but ensure move_uploaded_file is called
// and session updated accordingly.
if ($action === 'update_profile') {
    if (!isset($_SESSION['user_id'])) {
        die("❌ Unauthorized access.");
    }

    $id = $_SESSION['user_id'];
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $password = $_POST['new_password'] ?? '';

    if (!$first || !$last || !$email || !$age) {
        die("❌ Please fill all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email address.");
    }

    $updates = [];
    $params = [];
    $paramTypes = '';

    $updates[] = "first_name = ?";
    $params[] = $first;
    $paramTypes .= 's';

    $updates[] = "last_name = ?";
    $params[] = $last;
    $paramTypes .= 's';

    $updates[] = "email = ?";
    $params[] = $email;
    $paramTypes .= 's';

    $updates[] = "age = ?";
    $params[] = $age;
    $paramTypes .= 'i';

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "password = ?";
        $params[] = $hashed;
        $paramTypes .= 's';
    }

    if (!empty($_FILES['profile_picture']['name'])) {
        $imgError = validateImageUpload($_FILES['profile_picture']);
        if ($imgError) {
            die($imgError);
        }

        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $target = "uploads/" . uniqid('profile_', true) . "." . $ext;

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            die("❌ Failed to upload new profile picture.");
        }

        $updates[] = "profile_picture = ?";
        $params[] = $target;
        $paramTypes .= 's';

        $_SESSION['profile_picture'] = $target;
    }

    $setClause = implode(", ", $updates);
    $params[] = $id;
    $paramTypes .= 'i';

    $stmt = $conn->prepare("UPDATE users SET $setClause WHERE id = ?");
    $stmt->bind_param($paramTypes, ...$params);

    if ($stmt->execute()) {
        echo "✅ Profile updated. <a href='edit_profile.php'>Back to Profile</a>";
    } else {
        echo "❌ Error updating profile: " . $stmt->error;
    }
    exit;
}
?>
