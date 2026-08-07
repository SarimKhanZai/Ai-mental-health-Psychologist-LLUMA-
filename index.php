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
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LLUMA — Calm AI Psychologist Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* ---------- KEEPING YOUR ORIGINAL STYLES ---------- */
    :root{
      --muted:#bfc4cc;
      --accent:#9b8cff;
      --accent-2:#6ee7b7;
      --glass: rgba(255,255,255,0.05);
      --glow: 0 6px 30px rgba(155,140,255,0.14);
      --radius:16px;
      --transition: 240ms cubic-bezier(.2,.9,.3,1);
      --panel-bg: rgba(255,255,255,0.45);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:'Poppins', system-ui;
      color:#e6eef8;
      -webkit-font-smoothing:antialiased;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:28px;
      background:url('leaf.jpeg');
      background-size:cover;
      background-position:center;
    }
    .card-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }
    .card-link:visited,
    .card-link:hover,
    .card-link:active {
      text-decoration: none;
      color: inherit;
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
    nav a:hover{background:rgba(255,255,255,0.05);transform:translateY(-3px);}
    .top-controls{display:flex;align-items:center;gap:12px;}
    .icon-btn{
      background:var(--glass);
      border-radius:10px;
      padding:8px 10px;
      display:inline-flex;
      align-items:center;
      gap:8px;
      border:1px solid rgba(255,255,255,0.03);
      cursor:pointer;
      transition:transform var(--transition);
      color:#fff;
      font-size:15px;
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
      border-radius:12px;padding:10px;min-width:120px;
      border:1px solid rgba(255,255,255,0.05);
      display:none;z-index:20;
    }
    .dropdown a{
      display:block;padding:8px 10px;border-radius:8px;
      color:#fff;text-decoration:none;font-size:14px;
    }
    .dropdown a:hover{background:rgba(255,255,255,0.08)}
    .main{
      display:grid;
      grid-template-columns:1fr 340px;
      gap:18px;
    }
    .panel{
      background:var(--panel-bg);
      border-radius:var(--radius);
      padding:20px;
      border:1px solid rgba(0,0,0,0.06);
      color:#000;
    }
    .hero{display:flex;flex-direction:column;gap:14px;}
    .greeting{font-size:20px;font-weight:600;color:#000;}
    .greeting small{color:#333;font-size:13px;margin-top:6px;}
    .mood-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px;}
    .mood{
      padding:8px 14px;border-radius:999px;
      background:rgba(0,0,0,0.06);
      cursor:pointer;border:1px solid rgba(0,0,0,0.05);
      transition:all var(--transition);
      display:flex;align-items:center;gap:10px;color:#000;
    }
    .mood:hover{transform:translateY(-5px)}
    .mood.selected{
      background:linear-gradient(90deg,rgba(155,140,255,0.3),rgba(110,231,183,0.24));
      border-color:rgba(155,140,255,0.35);
    }
    .start-btn{
      padding:12px 18px;
      border-radius:12px;
      background:linear-gradient(90deg,var(--accent),#7fa7ff);
      color:#fff;font-weight:700;border:none;
      cursor:pointer;
      box-shadow:0 12px 40px rgba(124,101,255,0.2);
    }
    .cards{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:18px;}
    .card{padding:14px;border-radius:12px;background:rgba(255,255,255,0.55);}
    .card h3{margin:0;font-size:14px;color:#000;}
    .card p{margin:3px 0 0;color:#444;font-size:13px;}
    .quote{
      font-size:13px;color:#444;padding:14px;
      background:rgba(255,255,255,0.65);border-radius:12px;
    }
    .mood-meter{
      margin-top:15px;
      height:20px;
      width:100%;
      background:rgba(0,0,0,0.1);
      border-radius:10px;
      overflow:hidden;
    }
    .mood-meter-fill{
      height:100%;
      width:0%;
      background:linear-gradient(90deg,var(--accent-2),var(--accent));
      transition: width 0.3s ease;
    }
    .help-box{
      margin-top:18px;
      padding:12px;
      background:rgba(255,255,255,0.65);
      border-radius:12px;
      color:#000;
      font-size:14px;
      line-height:1.5;
    }
    footer{text-align:center;margin-top:14px;font-size:13px;color:var(--muted);}
    .popup-bg{
      position:fixed;
      top:0;left:0;
      width:100%;height:100%;
      background:rgba(0,0,0,0.7);
      backdrop-filter:blur(4px);
      display:flex;
      align-items:center;
      justify-content:center;
      z-index:9999;
    }
    .popup-box{
      width:420px;
      background:rgba(255,255,255,0.15);
      padding:22px;
      border-radius:18px;
      backdrop-filter:blur(12px);
      border:1px solid rgba(255,255,255,0.08);
      box-shadow:var(--glow);
      color:white;
      text-align:center;
    }
    .popup-btn{
      margin-top:15px;
      width:100%;
      padding:10px;
      border:none;
      border-radius:12px;
      cursor:pointer;
      font-weight:600;
      font-size:15px;
      color:white;
      background:linear-gradient(90deg,var(--accent),#7fa7ff);
    }
    .popup-btn.red{
      background:linear-gradient(90deg,#ff5d5d,#ff3c3c);
    }
    .chat-window {
      position: fixed;
      right: 30px;
      bottom: 30px;
      width: 420px;
      height: 580px;
      max-width: calc(100% - 60px);
      background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.1));
      border: 1px solid rgba(255,255,255,0.08);
      backdrop-filter: blur(14px);
      border-radius: 16px;
      box-shadow: 0 30px 80px rgba(10,10,25,0.45);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 99999;
      transition: transform 260ms var(--transition), opacity 220ms ease;
      transform: translateY(8px) scale(.98);
      opacity: 0;
    }
    .chat-window.open {
      display: flex;
      transform: translateY(0) scale(1);
      opacity: 1;
    }
    .chat-header-lluma {
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:12px 14px;
      border-bottom:1px solid rgba(255,255,255,0.04);
      background: linear-gradient(90deg, rgba(155,140,255,0.06), rgba(110,231,183,0.03));
      color:#fff;
      font-weight:700;
    }
    .chat-header-lluma .title { display:flex; gap:10px; align-items:center; }
    .chat-header-lluma .logo { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,var(--accent),#7da3ff);
      box-shadow: 0 8px 30px rgba(124,101,255,0.12);
      color:white;font-weight:700;
    }
    .chat-header-lluma .controls { display:flex; gap:8px; align-items:center; }
    .chat-body-lluma {
      padding:14px;
      flex:1;
      overflow-y:auto;
      display:flex;
      flex-direction:column;
      gap:10px;
      background: rgba(255,255,255,0.15);
    }
    .msg {
      max-width:85%;
      padding:10px 12px;
      border-radius:12px;
      font-size:14px;
      line-height:1.35;
      box-shadow: 0 6px 20px rgba(4,6,12,0.06);
    }
    .msg.bot {
      align-self:flex-start;
      background: rgba(255,255,255,0.15);
      color:#000;
    }
    .msg.user {
      align-self:flex-end;
      background: linear-gradient(90deg,var(--accent),#7fa7ff);
      color:#fff;
    }
    .chat-input-lluma {
      display:flex;
      gap:8px;
      padding:12px;
      border-top:1px solid rgba(255,255,255,0.04);
      background: rgba(255,255,255,0.12);
    }
    .chat-input-lluma input {
      flex:1;
      padding:10px 12px;
      border-radius:10px;
      border:1px solid rgba(255,255,255,0.04);
      background: rgba(255,255,255,0.1);
      color:#000;
      font-size:14px;
    }
    .chat-input-lluma input::placeholder { color: rgba(0,0,0,0.5); }
    .chat-input-lluma button {
      padding:10px 12px;
      border-radius:10px;
      border:none;
      cursor:pointer;
      font-weight:700;
      background: linear-gradient(90deg,var(--accent),#7fa7ff);
      color:#fff;
    }
    @media (max-width:800px) {
      .chat-window { right: 16px; left: 16px; width: auto; height: 62vh; }
    }
  </style>
</head>
<body>
<!-- AGE POPUP -->
<div class="popup-bg" id="agePopup">
  <div class="popup-box">
    <h2>⚠ Age & Safety Disclaimer</h2>
    <p style="font-size:14px;line-height:1.6;margin-top:10px;">
      LLUMA is an <strong>AI-based emotional support assistant</strong> and not a licensed
      clinical psychologist.  
      <br><br>
      This platform is intended for individuals who are
      <strong>16 years or older</strong> for safe and responsible use.
    </p>

    <button class="popup-btn" id="ageYes">I am 16 or Older</button>
    <button class="popup-btn red" id="ageNo">I am Under 16</button>
  </div>
</div>

<div class="app">
  <!-- HEADER -->
  <header>
    <div class="brand">
      <div class="logo-lluma">LLUMA</div>
      <div class="subtitle" style="font-size:13px;opacity:.9">Mind Wellness Space</div>
    </div>
    <div style="display:flex;align-items:center;gap:18px;">
      <nav><a href="#">Community</a></nav>
      <?php if (!$logged_in): ?>
          <a href="lluma.php"><button class="signup-btn">Sign Up</button></a>
      <?php endif; ?>
      <div class="top-controls">
        <?php if ($logged_in): ?>
            <button class="icon-btn">🔔</button>
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

  <!-- MAIN BODY -->
  <main class="main">
    <!-- LEFT PANEL -->
    <section class="panel hero">
      <div class="greeting">Hello, <?php echo $logged_in ? $username : "Guest"; ?> 👋</div>
      <small>How are you feeling today?</small>

      <div class="mood-row">
        <div class="mood" data-value="25">😊 Happy</div>
        <div class="mood" data-value="50">🌿 Calm</div>
        <div class="mood" data-value="75">😟 Stressed</div>
        <div class="mood" data-value="100">😠 Angry</div>
      </div>

      <button class="start-btn" id="startChatBtn">💬 Start Conversation</button>

      <div class="cards">
        <a href="neuro.php" class="card-link"><div class="card"><h3>Neuro Well Academy</h3><p>Write a private entry.</p></div></a>
        <a href="calm.php" class="card-link"><div class="card"><h3>🎧 Calm Music</h3><p>Relaxing activities.</p></div></a>
        <a href="medi.php" class="card-link"><div class="card"><h3>📈 Meditation</h3><p>Track mood & wins.</p></div></a>
        <a href="beats.php" class="card-link"><div class="card"><h3>🌿 Binoral Beats</h3><p>Guided well-being.</p></div></a>
      </div>
    </section>

    <!-- RIGHT PANEL -->
    <aside class="panel sidebar">
      <h4>Well-being Snapshot</h4>
      <small>Weekly mood balance</small>

      <div class="mood-meter"><div class="mood-meter-fill" id="moodMeterFill"></div></div>
      <div class="quote">I choose peace over pressure.</div>

      <div class="help-box">
        <strong>Crisis Support (24/7):</strong><br>
        • <strong>Umang Helpline:</strong> +923117786264<br>
        • <strong>Humraaz Govt Helpline:</strong> 1166<br><br>
        <em>This support is for emotional or mental health crises.</em>
      </div>
    </aside>
  </main>

  <footer>© 2025 LLUMA — Listen · Understand · Heal</footer>
</div>

<!-- CHAT WINDOW -->
<div class="chat-window" id="chatWindow">
  <div class="chat-header-lluma">
    <div class="title"><div class="logo">💜</div>LLUMA</div>
    <div class="controls">
      <button id="closeChat" style="background:none;border:none;color:white;font-size:18px;cursor:pointer;">✖</button>
    </div>
  </div>
  <div class="chat-body-lluma" id="chatBody">
    <div class="msg bot">Hello! I’m LLUMA. How are you feeling today?</div>
  </div>
  <div class="chat-input-lluma">
    <input type="text" id="chatInput" placeholder="Type a message..." />
    <button id="sendMsg">Send</button>
  </div>
</div>

<script>
    // PROFILE DROPDOWN
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if(profileBtn){
      profileBtn.addEventListener('click',(e)=>{
        e.stopPropagation();
        profileMenu.style.display = profileMenu.style.display==='block'?'none':'block';
      });
    }
    document.addEventListener('click',()=>{ if(profileMenu) profileMenu.style.display='none'; });

    // MOOD SELECTION
    const moodButtons = document.querySelectorAll('.mood');
    const moodFill = document.getElementById('moodMeterFill');

    moodButtons.forEach(m => {
      m.addEventListener('click', () => {
        moodButtons.forEach(x => x.classList.remove('selected'));
        m.classList.add('selected');
        const value = m.getAttribute('data-value');
        moodFill.style.width = value + '%';
      });
    });

    // AGE POPUP LOGIC
    const popup = document.getElementById("agePopup");
    const ageYes = document.getElementById("ageYes");
    const ageNo = document.getElementById("ageNo");

    ageYes.onclick = () => { popup.style.display = "none"; };
    ageNo.onclick = () => { 
      alert("Access denied. You must be 16 or older to use LLUMA.");
      window.location.href = "https://google.com"; 
    };

    // CHAT WINDOW LOGIC
    const startChatBtn = document.getElementById("startChatBtn");
    const chatWindow = document.getElementById("chatWindow");
    const closeChat = document.getElementById("closeChat");
    const chatBody = document.getElementById("chatBody");
    const chatInput = document.getElementById("chatInput");
    const sendMsg = document.getElementById("sendMsg");

    // Conversation array (frontend memory)
    let conversation = [];

    startChatBtn.addEventListener('click', () => {
      chatWindow.classList.add('open');
    });

    closeChat.addEventListener('click', () => {
      chatWindow.classList.remove('open');
    });

    function appendMessage(text, sender){
      const msgDiv = document.createElement('div');
      msgDiv.className = 'msg ' + sender;
      msgDiv.textContent = text;
      chatBody.appendChild(msgDiv);
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    async function sendToAI(message){
      appendMessage(message, 'user');
      chatInput.value = '';

      // Add message to conversation array for context
      conversation.push({author:'user', content: message});

      // Prepare form data for POST
      const formData = new FormData();
      formData.append('message', message);

      try{
        const response = await fetch('chat.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();
        const aiReply = data.reply || "I'm here with you.";

        appendMessage(aiReply, 'bot');

        // Add AI reply to conversation
        conversation.push({author:'assistant', content: aiReply});

      } catch(err){
        appendMessage("Error connecting to AI.", 'bot');
      }
    }

    sendMsg.addEventListener('click', ()=>{
      const text = chatInput.value.trim();
      if(text === '') return;
      sendToAI(text);
    });

    chatInput.addEventListener('keypress', (e)=>{
      if(e.key === 'Enter') sendMsg.click();
    });

fetch('chat.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'message=' + encodeURIComponent(userInput)
})
.then(response => response.json())
.then(data => {
    if (data.error) {
        console.error('Error:', data.error);
        // Display error to user
    } else {
        console.log('Reply:', data.reply);
        // Display reply to user
    }
})
.catch(error => {
    console.error('Fetch error:', error);
});
</script>

</body>
</html>
