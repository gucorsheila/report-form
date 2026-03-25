<?php
$conn = new mysqli("localhost", "root", "", "reportform_db");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $location = $_POST['location'];

    $ref = "INC-" . rand(1000,9999);

    $conn->query("INSERT INTO incidents 
    (reference_code, reporter_name, title, description, location) 
    VALUES ('$ref','$name','$title','$desc','$location')");

    echo "<div class='alert alert-success text-center'>
            Report Submitted! <br> Your Reference Code: <b>$ref</b>
          </div>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Report Incident</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow">
<div class="card-header bg-primary text-white">
    <h4>Report an Incident</h4>
</div>

<div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100" name="submit">
        Submit Report
    </button>
</form>
</div>
</div>
</div>

</body>
</html>