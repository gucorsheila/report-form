<?php
$conn = new mysqli("localhost", "root", "", "reportform_db");

$result = null;

if(isset($_POST['search'])){
    $ref = $_POST['ref'];

    $result = $conn->query("SELECT * FROM incidents WHERE reference_code='$ref'");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Check Status</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow">
<div class="card-header bg-success text-white">
    <h4>Check Report Status</h4>
</div>

<div class="card-body">

<form method="POST">
    <input type="text" name="ref" placeholder="Enter Reference Code" class="form-control mb-3" required>
    <button name="search" class="btn btn-success w-100">Search</button>
</form>

<?php if($result && $result->num_rows > 0){ 
    $row = $result->fetch_assoc(); ?>

    <div class="mt-4">
        <h5>Status: 
            <span class="badge bg-primary"><?php echo $row['status']; ?></span>
        </h5>
        <p><b>Title:</b> <?php echo $row['title']; ?></p>
        <p><b>Location:</b> <?php echo $row['location']; ?></p>
    </div>

<?php } ?>

</div>
</div>
</div>

</body>
</html>