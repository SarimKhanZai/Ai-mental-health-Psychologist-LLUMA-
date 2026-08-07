<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lluma_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Registration
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for duplicate email
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "⚠️ Email already registered!";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            $message = "✅ Registration successful! You can now log in.";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}

// Login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $message = "❌ Incorrect password!";
        }
    } else {
        $message = "⚠️ No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calm Forest Login & Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body{height:100vh;display:flex;align-items:center;justify-content:center;background:url('leaf.jpeg')no-repeat center/cover;overflow:hidden;}
    .container{width:850px;height:550px;display:flex;background:rgba(255,255,255,0.08);border-radius:16px;backdrop-filter:blur(12px);
      box-shadow:0 4px 30px rgba(0,0,0,0.3);overflow:hidden;position:relative;transition:all 0.8s ease;}
    .form-box{position:absolute;width:50%;height:100%;padding:60px;display:flex;flex-direction:column;justify-content:center;
      transition:0.8s ease;background:rgba(255,255,255,0.05);backdrop-filter:blur(20px);}
    .logo-right{position:absolute;right:100px;top:200px;text-align:right;color:#fff;}
    .logo-right h1{font-size:2.8rem;font-weight:600;letter-spacing:5px;text-shadow:0 0 15px rgba(255,255,255,0.4);}
    .logo-right p{font-size:0.95rem;font-weight:300;color:#e0e0e0;}
    .form-box h2{font-size:2rem;font-weight:600;margin-bottom:10px;color:black;}
    .form-box p{font-size:0.9rem;color:black;margin-bottom:30px;}
    label{display:block;margin-bottom:6px;font-weight:500;font-size:0.9rem;color:black;}
    input{width:100%;padding:12px;border:none;border-radius:8px;background:rgba(255,255,255,0.15);color:white;
      outline:none;font-size:0.95rem;margin-bottom:20px;transition:0.3s;}
    input:focus{background:rgba(255,255,255,0.25);}
    .login-btn,.register-btn{width:100%;padding:12px;border:none;border-radius:8px;background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:white;font-size:1rem;font-weight:500;cursor:pointer;transition:all 0.3s ease;}
    .login-btn:hover,.register-btn:hover{background:linear-gradient(135deg,#2c5364,#203a43,#0f2027);transform:scale(1.03);}
    .toggle-link{margin-top:20px;font-size:0.85rem;color:#cfcfcf;text-align:center;}
    .toggle-link a{color:#fff;text-decoration:none;font-weight:500;}
    .toggle-link a:hover{text-decoration:underline;}
    .left-bg{flex:1;background:url('forest.jpeg')no-repeat center center/cover;filter:brightness(70%);}
    .container.active .login-box{transform:translateX(-100%);opacity:0;}
    .container.active .register-box{transform:translateX(0%);opacity:1;}
    .login-box{left:0;transform:translateX(0%);opacity:1;}
    .register-box{left:0;transform:translateX(100%);opacity:0;}
    .message{position:absolute;top:20px;width:100%;text-align:center;color:white;font-weight:500;}
    @media(max-width:768px){.container{flex-direction:column;width:90%;height:auto;}
      .left-bg{display:none;}.form-box{width:100%;padding:40px;}
      .logo-right{position:static;text-align:center;margin-top:20px;}}
  </style>
</head>
<body>
  <div class="container" id="container">
    <div class="left-bg"></div>
    <div class="message"><?= $message ?></div>

    <!-- Login Box -->
    <div class="form-box login-box">
      <h2>Welcome back</h2>
      <p>Please enter your details.</p>
      <form method="POST" action="">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Enter your e-mail" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="••••••••" required>

        <button class="login-btn" type="submit" name="login">Log in</button>
        <div class="toggle-link">
          Don't have an account? <a href="#" id="show-register">Register here</a>
        </div>
      </form>
    </div>

    <!-- Register Box -->
    <div class="form-box register-box">
      <h2>Create Account</h2>
      <p>Join us and feel the calm of the forest.</p>
      <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>

        <label for="email-reg">E-mail</label>
        <input type="email" name="email" id="email-reg" placeholder="Enter your e-mail" required>

        <label for="password-reg">Password</label>
        <input type="password" name="password" id="password-reg" placeholder="••••••••" required>

        <button class="register-btn" type="submit" name="register">Register</button>
        <div class="toggle-link">
          Already have an account? <a href="#" id="show-login">Login here</a>
        </div>
      </form>
    </div>

    <!-- LLUMA Logo + Quote -->
    <div class="logo-right">
      <h1>LLUMA</h1>
      <p>Listen - Understand - Heel</p>
    </div>
  </div>

  <script>
    const container=document.getElementById('container');
    const showRegister=document.getElementById('show-register');
    const showLogin=document.getElementById('show-login');
    showRegister.addEventListener('click',(e)=>{e.preventDefault();container.classList.add('active');});
    showLogin.addEventListener('click',(e)=>{e.preventDefault();container.classList.remove('active');});
  </script>
</body>
</html>
