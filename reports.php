<?php
session_start();
$conn = new mysqli("localhost", "root", "", "cirs_db");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

$result = $conn->query("SELECT * FROM incidents");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<h3>📋 All Incident Reports</h3>

<table class="table table-bordered table-striped mt-3">
<tr class="table-dark">
    <th>Ref Code</th>
    <th>Name</th>
    <th>Title</th>
    <th>Description</th>
    <th>Location</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
    <td><?php echo $row['reference_code']; ?></td>
    <td><?php echo $row['reporter_name']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td>
        <a href="update.php?id=<?php echo $row['incident_id']; ?>" class="btn btn-warning btn-sm">
            Update
        </a>
    </td>
</tr>
<?php } ?>
</table>

<a href="dashboard.php" class="btn btn-secondary">⬅ Back</a>

</div>

</body>
</html>