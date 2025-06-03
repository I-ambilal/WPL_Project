<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: signup.php');
    exit();
}

$loggedIn = isset($_SESSION['user_id']);
$username = $loggedIn ? $_SESSION['first_name'] : '';
$email = $loggedIn ? $_SESSION['user_email'] : '';
$profileImage = $_SESSION['profile_picture'] ?? '';

// If image file doesn't exist or is empty, fallback to default
if (empty($profileImage) || !file_exists($profileImage)) {
    $profileImage = "11.jpeg"; // Default image path (make sure this exists)
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DJ Lisa</title>
  <style>
/* ========== Animations ========== */

/* Fade-in animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Zoom-in image */
@keyframes zoomIn {
  from {
    transform: scale(1.05);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

/* Glowing animation for header */


/* Apply fade-in to each box */
.grid .box,
.last-box .box,
.media-details1 {
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

/* Delay for nice staggered effect */
.grid .box:nth-child(1) { animation-delay: 0.2s; }
.grid .box:nth-child(2) { animation-delay: 0.4s; }
.grid .box:nth-child(3) { animation-delay: 0.6s; }
.grid .box:nth-child(4) { animation-delay: 0.8s; }
.last-box .box { animation-delay: 1s; }
.media-details1 { animation-delay: 1.2s; }

/* Image zoom effect on load */
.dj-photo img {
  animation: zoomIn 1.2s ease-out forwards;
  transform: scale(1.05);
  opacity: 0;
}

/* Header glow */
header {
  animation: glow 3s infinite alternate;
}

/* Hover effect for links */
nav a,
.contact a,
.media-details1 a {
  transition: color 0.3s, transform 0.3s;
}



/* Smooth transitions for all boxes */
.box {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}



    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #1a1a1a;
      color: #000;
      padding: 20px;
      
    }

    .container {
      max-width: 100%;
      margin: auto;
    }

    header {
      display: flex;
      justify-content: space-between;
    background-color: oklch(44.4% 0.011 73.639);

      align-items: center;
      margin-bottom: 30px;
      color: #000000;
      padding: 10px;
      border-radius: 10px;

      
    }
   
    header h1 {
      font-weight: bold;
      letter-spacing: 2px;
    }

    nav a {
      margin-left: 24px;
      text-decoration: none;
      color: #000000;
      font-size: 14px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: repeat(3, auto);
      gap: 20px;
    }

    .box {
      border-radius: 16px;
      padding: 24px;
    }

    .tagline {
      background-color:oklch(70.9% 0.01 56.259);
      grid-column: span 2;
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      line-height: 1.3;
    }

    .tagline em {
      font-style: italic;
    }

    .bio {
    background-color: oklch(44.4% 0.011 73.639);
     color: #aaa;
      grid-column: span 2;
      font-size: 14px;
    font-weight:900 ;

    }

    .dj-photo {
      
      height: 680px;       /* lock container height */
      grid-row: span 2;
      overflow: hidden;
      padding: 0;
      
    }

    .dj-photo img {



      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: grayscale(0);
      border-radius: 16px;
    }

    .events {
    background-color: oklch(44.4% 0.011 73.639);
      grid-row: span 2;
      font-size: 14px;
      
    }

    .events img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .events h3 {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .events p {
      border-top: 1px solid #aaa;
      padding-top: 10px;
      margin-top: 10px;
    }

    .last-box{
       
        
        gap: 10px;
        display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: repeat(2, auto);
    }
    .contact {
    grid-column: span 3;
    grid-row: span 2;
      background-color:oklch(70.9% 0.01 56.259);
        
      color: #000000;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .contact a {
      margin-top: auto;
      color: #000000;
      text-decoration: none;
      font-size: 18px;
    }

    .media-details1 {
    grid-column: span 1;
            grid-row: span 2;

      display: flex;
      flex-direction: row;
     justify-content: center;      
     align-items: center;
     gap: 15px;
      background-color:oklch(70.9% 0.01 56.259);

      padding: 16px ;
      border-radius: 16px;

      font-size: 14px;
    }
    

    .media-details1 a {
      color: #000;
      text-decoration: none;
      
    }
  

     @media (max-width: 768px) {
      .grid {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto;
      }

      .tagline, .bio, .footer {
        grid-column: span 2;
      }

      .dj-photo, .events, .contact {
        grid-column: span 1;
      }
    }

    @media (max-width: 500px) {
      .grid {
        grid-template-columns: 1fr;
      }

      .tagline, .bio, .footer, .dj-photo, .events, .contact {
        grid-column: span 1;
      }
    } 
    ::-webkit-scrollbar {
            width: 0;
            
         }
         .dj-photo img {
  transition: opacity 1s ease-in-out;
}

.dj-photo img.fade {
  opacity: 0;
}
/* Base style for slideshow image */
#slideshow {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 16px;
  transition: transform 1s ease, opacity 1s ease;
  opacity: 1;
}

/* Animate out */
#slideshow.fade-out {
  opacity: 0;
  transform: scale(1.1) rotate(2deg);
}

/* Animate in */
#slideshow.fade-in {
  opacity: 1;
  transform: scale(1) rotate(0deg);
}

.dj-photo {
  height: 680px;       /* lock container height */
  overflow: hidden;    /* crop anything outside */
}

/* ========== Profile Dropdown ========== */
    .profile-container {
      position: relative;
      cursor: pointer;
      width: 50px;
      height: 50px;
    }

    .profile-img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #000000;
    }

    .dropdown {
      position: absolute;
      top: 60px;
      left: 0;
   
      background-color:oklch(70.9% 0.01 56.259);
      border: 1px solid #ccc;
      border-radius: 16px;
      /* box-shadow: 0 4px 8px rgba(0,0,0,0.1); */
      width: 220px;
      padding: 15px;
      display: none;
      z-index: 1000;
    }

    .user-info div {
      font-size: 14px;
      color: #000000;
      margin-bottom: 6px;
    }

    .username {
      font-weight: bold;
      font-size: 16px;
    }

    .dropdown a.button-link {
      display: block;
      text-align: center;
      background-color: #000000;
      color: rgb(255, 255, 255);
      padding: 8px 0;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 5px;
    }

    .dropdown button.logout {
      width: 100%;
      padding: 8px 0;
      margin-top: 5px;
      background-color: #000000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .dropdown button:hover, .button-link:hover {
      opacity: 0.9;
    }  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="profile-container" id="profileContainer">
        <img class="profile-img" src="<?= htmlspecialchars($profileImage) ?>" alt="User Profile Picture" />
        <div class="dropdown" id="dropdownMenu" role="menu" aria-hidden="true">
          <div class="user-info">
            <div class="username"><?= htmlspecialchars($username) ?></div>
            <div class="email"><?= htmlspecialchars($email) ?></div>
          </div>
          <a class="button-link" href="edit_profile.php">Edit Profile</a>
          <form method="POST" action="logout.php">
            <button class="logout" type="submit">Logout</button>
          </form>
        </div>
      </div>

      <nav>
        <a href="#">ABOUT</a>
        <a href="#">WEDDINGS</a>
        <a href="signup.php">Login</a>
      </nav>
    </header>



    <!-- ✅ Everything else stays the same -->
    <div class="grid">
      <div class="box tagline">
        Let's create dance floor <em>magic</em> for your special day
      </div>

      <div class="box dj-photo">
        <img id="slideshow" src="1.jpeg" alt="DJ Lisa">
      </div>

      <div class="box events">
        <h3>Song Name</h3>
        <img src="https://i.pinimg.com/736x/25/e0/14/25e0140ce2cc0c4dfd301b0f7a1ecb85.jpg" alt="First Dance">
        <p>Singer Name</p>
        <p>Album Name</p>
      </div>

      <div class="box bio">
        DJ Lisa is a passionate wedding DJ, acclaimed for blending diverse musical genres with expert crowd-reading skills.
        Based in Florida, she crafts personalized soundtracks that turn every wedding into an unforgettable celebration.
      </div>
    </div>

    <div class="last-box">
      <div class="box contact">
        <p>Have some questions?</p>
        <a href="#">Contact me</a>
      </div>

      <div class="media-details1">
        <a href="https://www.instagram.com/dualipa/?hl=en">INSTAGRAM</a>
        <a href="#">TWITTER</a>
        <a href="#">PINTEREST</a>
      </div>
    </div>
  </div>
  </div>

  <script>
    // JavaScript for slideshow & dropdown toggle remains unchanged
    const profile = document.getElementById('profileContainer');
    const dropdown = document.getElementById('dropdownMenu');
    if (profile && dropdown) {
      profile.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
      });
    }
  </script>
</body>
</html>
