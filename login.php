<?php
session_start();
$conn = new mysqli("localhost", "root", "", "reportform_db");

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $result = $conn->query("SELECT * FROM officials 
                           WHERE username='$user' AND password='$pass'");

    if($result->num_rows > 0){
        $_SESSION['admin'] = $user;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Barangay Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    height: 100vh;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI';
}

.login-card {
    width: 350px;
    padding: 30px;
    border-radius: 20px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    color: white;
}

.form-control {
    border-radius: 10px;
}

.btn-custom {
    border-radius: 10px;
    background: #ffffff;
    color: #333;
    font-weight: bold;
}

.btn-custom:hover {
    background: #f1f1f1;
}

.title {
    text-align: center;
    margin-bottom: 20px;
}
</style>

</head>

<body>

<div class="login-card">

    <h3 class="title">🏢 Barangay Portal</h3>

    <?php if(isset($error)){ ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <button type="button" class="btn btn-light" onclick="togglePass()">👁</button>
        </div>

        <button name="login" class="btn btn-custom w-100">Login</button>
    </form>

</div>

<script>
function togglePass(){
    let pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}
</script>

</body>
</html>