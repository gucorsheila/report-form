<?php
session_start();
$conn = new mysqli("localhost", "root", "", "reportform_db");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

// counts
$pending = $conn->query("SELECT COUNT(*) as total FROM incidents WHERE status='Pending'")->fetch_assoc()['total'];
$verified = $conn->query("SELECT COUNT(*) as total FROM incidents WHERE status='Verified'")->fetch_assoc()['total'];
$resolved = $conn->query("SELECT COUNT(*) as total FROM incidents WHERE status='Resolved'")->fetch_assoc()['total'];

// chart data
$status_data = [];
$query = $conn->query("SELECT status, COUNT(*) as total FROM incidents GROUP BY status");
while($row = $query->fetch_assoc()){
    $status_data[$row['status']] = $row['total'];
}

$result = $conn->query("SELECT * FROM incidents");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: #f4f6f9;
}

.sidebar {
    height: 100vh;
    width: 220px;
    position: fixed;
    background: #343a40;
    color: white;
    padding: 20px;
}

.sidebar h4 {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 10px;
    text-decoration: none;
    border-radius: 8px;
}

.sidebar a:hover {
    background: #495057;
}

.content {
    margin-left: 240px;
    padding: 20px;
}

.card-box {
    border-radius: 15px;
    color: white;
    padding: 20px;
}

.bg1 { background: #007bff; }
.bg2 { background: #ffc107; color:black; }
.bg3 { background: #28a745; }
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🏢 Barangay</h4>
    <a href="#">📊 Dashboard</a>
    <a href="#">📋 Reports</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<h3 class="mb-4">Dashboard Overview</h3>

<!-- CARDS -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card-box bg1">
            <h5>Pending</h5>
            <h2><?php echo $pending; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box bg2">
            <h5>Verified</h5>
            <h2><?php echo $verified; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box bg3">
            <h5>Resolved</h5>
            <h2><?php echo $resolved; ?></h2>
        </div>
    </div>
</div>

<!-- CHART -->
<div class="card p-3 mt-4">
    <h5>📅 Recent Reports</h5>

    <ul class="list-group">
    <?php
    $recent = $conn->query("SELECT * FROM incidents ORDER BY date_reported DESC LIMIT 5");

    if($recent->num_rows > 0){
        while($r = $recent->fetch_assoc()){
    ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <b><?php echo $r['title']; ?></b><br>
                <small><?php echo $r['location']; ?></small>
            </div>
            <span class="badge bg-primary"><?php echo $r['status']; ?></span>
        </li>
    <?php 
        }
    } else {
        echo "<li class='list-group-item'>No reports yet</li>";
    }
    ?>
    </ul>
</div>
<!-- TABLE -->
<div class="card p-3">
<h5>All Reports</h5>

<table class="table table-hover">
<tr class="table-dark">
    <th>Ref Code</th>
    <th>Name</th>
    <th>Title</th>
    <th>Location</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr class="<?php echo ($row['status']=='Pending') ? 'table-warning' : ''; ?>">
    <td><?php echo $row['reference_code']; ?></td>
    <td><?php echo $row['reporter_name']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td>
        <span class="badge bg-info"><?php echo $row['status']; ?></span>
    </td>
    <td>
        <a href="update.php?id=<?php echo $row['incident_id']; ?>" class="btn btn-sm btn-warning">Update</a>
    </td>
</tr>
<?php } ?>
</table>

</div>

</div>

<script>
const data = {
    labels: <?php echo json_encode(array_keys($status_data)); ?>,
    datasets: [{
        label: 'Reports',
        data: <?php echo json_encode(array_values($status_data)); ?>
    }]
};

new Chart(document.getElementById('myChart'), {
    type: 'bar',
    data: data
});
</script>

</body>
</html>