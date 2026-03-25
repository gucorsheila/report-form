<?php
$conn = new mysqli("localhost", "root", "", "reportform_db");

$id = $_GET['id'];

// fetch incident details
$data = $conn->query("SELECT * FROM incidents WHERE incident_id=$id")->fetch_assoc();

if(isset($_POST['update'])){
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    $conn->query("UPDATE incidents 
                  SET status='$status' 
                  WHERE incident_id=$id");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Incident</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
}

.card {
    border-radius: 15px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow">
<div class="card-header bg-dark text-white">
    <h4>🛠️ Update Incident</h4>
</div>

<div class="card-body">

<!-- INCIDENT DETAILS -->
<div class="mb-4">
    <h5>📋 Report Details</h5>
    <p><b>Reference Code:</b> <?php echo $data['reference_code']; ?></p>
    <p><b>Reported By:</b> <?php echo $data['reporter_name']; ?></p>
    <p><b>Title:</b> <?php echo $data['title']; ?></p>
    <p><b>Description:</b> <?php echo $data['description']; ?></p>
    <p><b>Location:</b> <?php echo $data['location']; ?></p>
</div>

<hr>

<!-- UPDATE FORM -->
<form method="POST">

<div class="mb-3">
<label>Update Status</label>
<select name="status" class="form-select" required>
    <option <?php if($data['status']=="Pending") echo "selected"; ?>>Pending</option>
    <option <?php if($data['status']=="Verified") echo "selected"; ?>>Verified</option>
    <option <?php if($data['status']=="Resolved") echo "selected"; ?>>Resolved</option>
    <option <?php if($data['status']=="Rejected") echo "selected"; ?>>Rejected</option>
</select>
</div>

<div class="mb-3">
<label>Remarks (Optional)</label>
<textarea name="remarks" class="form-control" placeholder="Enter action taken or notes..."></textarea>
</div>

<div class="d-flex justify-content-between">
    <a href="dashboard.php" class="btn btn-secondary">⬅ Back</a>
    <button name="update" class="btn btn-success">✅ Update</button>
</div>

</form>

</div>
</div>

</div>

</body>
</html>