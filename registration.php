<?php
// Validate and process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate form data
  $errors = array();
  
  // Full Name validation
  if (empty($_POST["full_name"])) {
    $errors[] = "Full Name is required";
  } else {
    $full_name = $_POST["full_name"];
    // Additional validation if needed
  }
  
  // Email validation
  if (empty($_POST["email"])) {
    $errors[] = "Email Address is required";
  } else {
    $email = $_POST["email"];
    // Additional validation if needed
  }
  
  // Gender validation
  if (empty($_POST["gender"])) {
    $errors[] = "Gender is required";
  } else {
    $gender = $_POST["gender"];
  }
  
  // If there are no errors, insert data into the database
  if (empty($errors)) {
    // Database connection details
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $database = "your_database";
    
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO students (full_name, email, gender) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $gender);
    
    if ($stmt->execute()) {
      $success_message = "Data inserted successfully!";
    } else {
      $errors[] = "Error inserting data: " . $conn->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Student Registration Form</title>
</head>
<body>
  <h1>Student Registration Form</h1>
  <?php if (isset($success_message)) { ?>
    <p><?php echo $success_message; ?></p>
  <?php } else { ?>
    <?php if (!empty($errors)) { ?>
      <ul>
        <?php foreach ($errors as $error) { ?>
          <li><?php echo $error; ?></li>
        <?php } ?>
      </ul>
    <?php } ?>
    
    <form method="POST" action="register.php">
      <label for="full_name">Full Name:</label>
      <input type="text" name="full_name" id="full_name" required><br><br>
      
      <label for="email">Email Address:</label>
      <input type="email" name="email" id="email" required><br><br>
      
      <label>Gender:</label>
      <input type="radio" name="gender" value="Male" required> Male
      <input type="radio" name="gender" value="Female" required> Female<br><br>
      
      <input type="submit" value="Submit">
    </form>
  <?php } ?>
</body>
</html>
