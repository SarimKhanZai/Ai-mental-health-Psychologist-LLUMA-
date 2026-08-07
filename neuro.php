<?php
session_start();

// Handle logout request
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// LOGIN CHECK
if (!isset($_SESSION['username'])) {
    $logged_in = false;
} else {
    $logged_in = true;
    $username = $_SESSION['username'];
}

// Example videos array
$videos = [
    [
        "title" => "Mindfulness for Beginners",
        "thumbnail" => "https://img.youtube.com/vi/w6T02g5hnT4/hqdefault.jpg",
        "url" => "https://www.youtube.com/watch?v=w6T02g5hnT4"
    ],
    [
        "title" => "Stress Relief Techniques",
        "thumbnail" => "https://img.youtube.com/vi/hnpQrMqDoqE/hqdefault.jpg",
        "url" => "https://www.youtube.com/watch?v=hnpQrMqDoqE"
    ],
    [
        "title" => "Meditation for Mental Health",
        "thumbnail" => "https://img.youtube.com/vi/inpok4MKVLM/hqdefault.jpg",
        "url" => "https://www.youtube.com/watch?v=inpok4MKVLM"
    ],
    [
        "title" => "Boost Your Happiness",
        "thumbnail" => "https://img.youtube.com/vi/YJ8T8Vn1Z4c/hqdefault.jpg",
        "url" => "https://www.youtube.com/watch?v=YJ8T8Vn1Z4c"
    ]
];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Neurowell Academy — Mind Wellness</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --muted:#bfc4cc;
      --accent:#9b8cff;
      --accent-2:#6ee7b7;
      --glass: rgba(255,255,255,0.05);
      --glow: 0 6px 30px rgba(155,140,255,0.14);
      --radius:16px;
      --transition: 240ms cubic-bezier(.2,.9,.3,1);
    }
    *{box-sizing:border-box;}
    html,body{height:100%;}
    body{
      margin:0;
      font-family:'Poppins', system-ui;
      color:#e6eef8;
      display:flex;
      align-items:flex-start;
      justify-content:center;
      padding:28px;
      background:url('leaf.jpeg');
      background-size:cover;
      background-position:center;
    }

    .app{
      width:100%;
      max-width:1130px;
      background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));
      border-radius:20px;
      padding:22px;
      box-shadow:var(--glow);
      backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,0.05);
      position:relative;
      margin-bottom:50px;
    }

    header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:16px;
      padding-bottom:6px;
      border-bottom:1px solid rgba(255,255,255,0.05);
    }

  .brand{display:flex;align-items:center;gap:12px;}
    .logo-lluma{
      font-weight:700;
      letter-spacing:4px;
      font-size:30px;
      color:#fff;
      text-shadow:0 0 10px rgba(255,255,255,0.18);
    }

    nav{display:flex;gap:18px;}
    nav a{
      color:white;
      text-decoration:none;
      font-weight:500;
      padding:7px 12px;
      border-radius:10px;
      transition:background var(--transition), transform var(--transition);
    }
    nav a:hover{
      background:rgba(255,255,255,0.05);
      transform:translateY(-3px);
    }

    .top-controls{display:flex;align-items:center;gap:12px;}

    .icon-btn{
      background:var(--glass);
      border-radius:10px;
      padding:8px 10px;
      display:inline-flex;
      align-items:center;
      border:1px solid rgba(255,255,255,0.03);
      cursor:pointer;
      color:#fff;
      transition:transform var(--transition);
    }
    .icon-btn:hover{transform:translateY(-3px)}

    .signup-btn{
      padding:8px 14px;
      border-radius:10px;
      background:linear-gradient(90deg,var(--accent),#7fa7ff);
      color:#fff;
      border:none;
      cursor:pointer;
      font-weight:600;
      box-shadow:0 6px 20px rgba(124,101,255,0.25);
    }

    .profile{position:relative;}
    .avatar{
      width:40px;height:40px;border-radius:10px;
      background:linear-gradient(180deg,#ffe 0%, #ffd 30%);
      display:flex;align-items:center;justify-content:center;
      color:#222;font-weight:700;
    }

    .dropdown{
      position:absolute;right:0;top:52px;
      background:var(--glass);
      border-radius:12px;padding:10px;
      min-width:120px;
      border:1px solid rgba(255,255,255,0.05);
      display:none;z-index:20;
    }
    .dropdown a{
      display:block;padding:8px 10px;border-radius:8px;
      color:#fff;text-decoration:none;font-size:14px;
    }
    .dropdown a:hover{background:rgba(255,255,255,0.08)}

    .main{display:flex;flex-direction:column;gap:20px;}

    .videos{
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
      gap:16px;
      margin-top:20px;
    }

    .video-card{
      background:rgba(255,255,255,0.45);
      border-radius:var(--radius);
      padding:8px;
      border:1px solid rgba(0,0,0,0.06);
      cursor:pointer;
      transition:all var(--transition);
    }
    .video-card:hover{
      transform:translateY(-5px);
      box-shadow:var(--glow);
    }
    .video-card img{
      width:100%;
      border-radius:12px;
    }
    .video-card h3{
      margin:8px 0 0;
      font-size:15px;
      color:#000;
    }

    footer{text-align:center;margin-top:14px;font-size:13px;color:var(--muted);}
  </style>
</head>

<body>

<div class="app">

  <header>
    <div class="brand">
      <div class="logo-lluma">Neurowell Academy</div>
     <div class="subtitle" style="font-size:13px;opacity:.9">Mind Wellness Space</div>
    </div>

    <div style="display:flex;align-items:center;gap:18px;">
      <nav>
        <a href="index.php" >Home</a>
        <a href="medi.php">Meditation</a>
        <a href="calm.php">Calm Music</a>
        <a href="beats.php">Binoral Beats</a>
      </nav>

      <?php if (!$logged_in): ?>
          <a href="lluma.php"><button class="signup-btn">Sign Up</button></a>
      <?php endif; ?>

      <div class="top-controls">
        <?php if ($logged_in): ?>
            <div class="profile">
              <button class="icon-btn" id="profileBtn">
                <div class="avatar"><?php echo strtoupper($username[0]); ?></div>
              </button>

              <div class="dropdown" id="profileMenu">
                <a href="index.php?logout=true">Logout</a>
              </div>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="main">
    <h2>📺 Learn & Explore</h2>

    <div class="videos">
      <?php foreach($videos as $vid): ?>
        <div class="video-card" onclick="window.open('<?php echo $vid['url']; ?>','_blank')">
          <img src="<?php echo $vid['thumbnail']; ?>" alt="<?php echo $vid['title']; ?>">
          <h3><?php echo $vid['title']; ?></h3>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer>© 2026 LLUMA — Listen · Understand · Heal</footer>

</div>

<script>
  // PROFILE DROPDOWN
  const profileBtn=document.getElementById('profileBtn');
  const profileMenu=document.getElementById('profileMenu');

  if(profileBtn){
    profileBtn.addEventListener('click',(e)=>{
      e.stopPropagation();
      profileMenu.style.display = profileMenu.style.display==='block'?'none':'block';
    });
  }

  document.addEventListener('click',()=>{ 
      if(profileMenu) profileMenu.style.display='none'; 
  });
</script>

</body>
</html>
