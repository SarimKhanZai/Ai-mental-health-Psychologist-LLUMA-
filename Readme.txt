                               LLUMA - MENTAL WELLNESS PLATFORM
================================================================================

                    Listen • Understand • Heal Mindfully & Authentically

================================================================================
                             PROJECT OVERVIEW
================================================================================

LLUMA is an AI-powered mental wellness platform designed to provide accessible,
immediate, and empathetic emotional support, specifically tailored for the 
Pakistani context. The platform combines an intelligent chatbot powered by 
Google's Gemini API with curated multimedia therapeutic content including 
meditation videos, calm music, binaural beats, and mental health education.

================================================================================
                              KEY FEATURES
================================================================================

 AI-POWERED CHATBOT - Empathetic conversations using Google Gemini 1.5 Flash
 CRISIS DETECTION - Automatic keyword detection with helpline redirection
 FALLBACK SYSTEM - Evidence-based coping techniques when API is unavailable
 MULTIMEDIA THERAPY - Meditation, calm music, binaural beats, education
 MOOD TRACKING - Visual mood meter for emotional self-monitoring
 SECURE AUTHENTICATION - User registration/login with bcrypt password hashing
 AGE VERIFICATION - 16+ access restriction with safety disclaimer
 RESPONSIVE DESIGN - Works on desktop, tablet, and mobile devices

================================================================================
                          CRISIS HELPLINES
================================================================================

When crisis keywords are detected, the system immediately displays:

    Umang Helpline (24/7):        +923117786264
    Humraaz Government Helpline:  1166

================================================================================
                          TECHNOLOGY STACK
================================================================================

Layer          | Technology              | Purpose
---------------|-------------------------|--------------------------------
Front-End      | HTML5, CSS3, JavaScript | User interface & interactivity
Back-End       | PHP 7.4+                | Server logic & API calls
Database       | MySQL 5.7+              | User data storage
AI API         | Google Gemini 1.5 Flash | Conversational AI responses
Web Server     | Apache (via XAMPP)      | Local hosting
Styling        | Custom CSS + Poppins    | Calming glassmorphism design

================================================================================
                          PREREQUISITES
================================================================================

Before installation, ensure you have:

[1] XAMPP (includes PHP, MySQL, Apache) - Download from www.apachefriends.org
[2] A web browser (Chrome, Firefox, Edge, Safari)
[3] Active internet connection (for Gemini API calls)
[4] Google Gemini API Key - Get from ai.google.dev/gemini-api

================================================================================
                          INSTALLATION GUIDE
================================================================================

STEP 1: INSTALL XAMPP
---------------------
Download and install XAMPP from www.apachefriends.org
Launch XAMPP Control Panel and start both Apache and MySQL services.

STEP 2: DOWNLOAD THE PROJECT
----------------------------
Download the project ZIP file and extract it.
Copy the extracted 'lluma' folder to:
    Windows: C:\xampp\htdocs\lluma\
    Linux:   /opt/lampp/htdocs/lluma/
    Mac:     /Applications/XAMPP/htdocs/lluma/

STEP 3: CREATE THE DATABASE
---------------------------
Open your browser and go to: http://localhost/phpmyadmin
Click "New" to create a database.
Name the database: lluma_db
Select "utf8_general_ci" as collation.
Click "Create".

STEP 4: CREATE THE USERS TABLE
------------------------------
Click on the 'lluma_db' database you just created.
Click the "SQL" tab.
Copy and paste the following SQL query:

-------------------------------------------------------------------------------
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-------------------------------------------------------------------------------

Click "Go" to execute the query.

STEP 5: CONFIGURE DATABASE CONNECTION
-------------------------------------
Open the file: lluma.php
Find these lines:
    $conn = new mysqli("localhost", "root", "", "lluma_db");
If your MySQL has a password, update accordingly:
    $conn = new mysqli("localhost", "root", "your_password", "lluma_db");

STEP 6: CONFIGURE GEMINI API KEY
--------------------------------
Open the file: chat.php
Find this line:
    $API_KEY = "xxxxxxxxxxxxxxxxxxxxxxxx";
Replace with your own Gemini API key:
    $API_KEY = "YOUR_ACTUAL_API_KEY_HERE";

STEP 7: ADD BACKGROUND IMAGES
-----------------------------
Place the following images in the 'lluma' folder:
    leaf.jpeg - Background image for dashboard and pages
    forest.jpeg - Background image for login/register page

STEP 8: ACCESS THE APPLICATION
------------------------------
Open your browser and go to:
    http://localhost/lluma/index.php

================================================================================
                          PROJECT FILE STRUCTURE
================================================================================

lluma/
│
├── index.php          # Main dashboard (Home page)
├── lluma.php          # Login and Registration page
├── chat.php           # AI Chatbot backend (Gemini API + fallback)
├── medi.php           # Meditation videos gallery
├── calm.php           # Calm music videos gallery
├── beats.php          # Binaural beats videos gallery
├── neuro.php          # Neurowell Academy (educational videos)
├── leaf.jpeg          # Background image for pages
├── forest.jpeg        # Background image for login page
│
└── README.txt         # This documentation file

================================================================================
                          HOW TO USE THE APPLICATION
================================================================================

FOR NEW USERS:
--------------
1. Open http://localhost/lluma/lluma.php
2. Click "Register here" link
3. Enter Username, Email, and Password
4. Click "Register" button
5. Login with your email and password

FOR EXISTING USERS:
-------------------
1. Open http://localhost/lluma/lluma.php
2. Enter your Email and Password
3. Click "Log in" button

AFTER LOGIN:
------------
1. Age Verification Popup appears - Click "I am 16 or Older"
2. Dashboard loads with:
   - Greeting message with your username
   - Mood selector (Happy, Calm, Stressed, Angry)
   - "Start Conversation" button for AI chat
   - Four video gallery cards
   - Well-being snapshot with crisis helplines

CHAT WITH LLUMA:
----------------
1. Click "Start Conversation" button
2. Chat window opens on the bottom-right corner
3. Type your message and press Enter or click Send
4. LLUMA will respond with empathetic support

EXPLORE VIDEO GALLERIES:
------------------------
1. Click on any card on the dashboard:
   - Meditation → Guided meditation videos
   - Calm Music → Relaxing music videos
   - Binaural Beats → Brainwave entrainment videos
   - Neurowell Academy → Educational mental health videos
2. Click on any video thumbnail to open on YouTube

TRACK YOUR MOOD:
----------------
Click on any mood button:
   - Happy (25% fill)
   - Calm (50% fill)
   - Stressed (75% fill)
   - Angry (100% fill)
The mood meter fill bar will update accordingly.

LOGOUT:
-------
1. Click on the profile icon (avatar) in the top-right corner
2. Click "Logout" from the dropdown menu

================================================================================
                          CHATBOT COMMAND EXAMPLES
================================================================================

USER SAYS                           | LLUMA RESPONSE
------------------------------------|----------------------------------------
"I feel anxious"                    | Offers box breathing & grounding
"I'm sad and lonely"                | Empathetic listening & coping strategies
"I'm feeling stressed about work"   | Provides stress relief techniques
"I want to kill myself"             | Displays crisis helpline numbers
"I'm not okay"                      | Validates feelings and offers support
"Thank you"                         | Warm acknowledgment and continued support
"What can you do?"                  | Lists capabilities and available techniques
"How are you?"                      | Warm response redirected to user
"Goodbye"                           | Wishes well and invites to return

================================================================================
                          TESTING THE SYSTEM
================================================================================

TEST CREDENTIALS:
-----------------
Create your own test account during registration.
No default credentials are provided for security.

TEST CRISIS DETECTION:
----------------------
Type any of these messages in the chat:
    "I want to kill myself"
    "I feel suicidal"
    "I want to die"
    "I'm going to hurt myself"
Expected Response: Helpline numbers displayed immediately.

TEST FALLBACK SYSTEM:
---------------------
To test the fallback system:
1. Open chat.php
2. Change the API key to an invalid one
3. Send any message to the chatbot
4. Expected Response: Coping technique from fallback library

TEST MOOD TRACKER:
------------------
Click each mood button and observe the mood meter fill bar changing.

================================================================================
                          EVIDENCE-BASED COPING TECHNIQUES (FALLBACK LIBRARY)
================================================================================

When the Gemini API is unavailable, LLUMA provides these techniques:

FOR ANXIETY:
------------
[1] Box Breathing: Inhale 4 sec -> Hold 4 sec -> Exhale 4 sec -> Hold 4 sec
[2] 5-4-3-2-1 Grounding: Name 5 things you see, 4 you touch, 3 you hear,
    2 you smell, 1 you taste
[3] Progressive Muscle Relaxation: Tense each muscle group for 5 seconds,
    then release
[4] Butterfly Hug: Cross arms over chest and tap alternately left-right

FOR STRESS:
-----------
[1] 5-Minute Meditation: Focus only on your breath
[2] Brain Dump: Write down everything on your mind for 5 minutes
[3] Mindful Walking: Walk and notice each step and sensation
[4] Nature Connection: Spend 5 minutes looking at plants or sky

FOR DEPRESSION:
---------------
[1] One Small Action: Do just ONE tiny thing (make bed, drink water)
[2] Opposite Action: Act opposite to emotional urges
[3] Self-Compassion Break: Place hand on heart and speak kindly
[4] Morning Sunlight: Spend 5 minutes in natural morning light

================================================================================
                          DATABASE SCHEMA
================================================================================

Database Name: lluma_db

Table: users
-------------------------------------------------------------------------------
Column Name   | Data Type      | Constraints                   | Description
--------------|----------------|-------------------------------|-----------------------------
id            | INT(11)        | PRIMARY KEY, AUTO_INCREMENT   | Unique user ID
username      | VARCHAR(50)    | NOT NULL                      | User's display name
email         | VARCHAR(100)   | NOT NULL, UNIQUE              | Login email address
password      | VARCHAR(255)   | NOT NULL                      | Bcrypt-hashed password
created_at    | TIMESTAMP      | DEFAULT CURRENT_TIMESTAMP     | Account creation date

================================================================================
                          TROUBLESHOOTING
================================================================================

PROBLEM: "Connection failed" error
SOLUTION: Check MySQL is running in XAMPP. Verify database credentials.

PROBLEM: White screen on login/register
SOLUTION: Enable PHP error reporting. Check Apache error logs.

PROBLEM: Chatbot not responding
SOLUTION: Check internet connection. Verify Gemini API key is valid.

PROBLEM: Images not loading
SOLUTION: Ensure leaf.jpeg and forest.jpeg are in the correct folder.

PROBLEM: Cannot access localhost
SOLUTION: Ensure Apache is running in XAMPP Control Panel.

PROBLEM: Session not persisting after login
SOLUTION: Check that session_start() is at the beginning of each PHP file.

================================================================================
                          SECURITY FEATURES
================================================================================

[1] Password Hashing: All passwords are hashed using bcrypt algorithm
[2] Session Management: PHP sessions with validation on protected pages
[3] Input Validation: Basic sanitization of user inputs
[4] Age Restriction: 16+ verification popup
[5] Crisis Protocol: Automatic helpline display for suicidal keywords
[6] No Permanent Chat Storage: Chat history stored only in session memory

================================================================================
                          FUTURE ENHANCEMENTS
================================================================================

SHORT-TERM (3-6 months):
------------------------
 Urdu language support with language toggle
 Expanded video library (20+ videos per category)
 Mood tracking dashboard with weekly/monthly charts
 Encrypted chat history persistence
 Dark mode theme toggle

MEDIUM-TERM (6-12 months):
--------------------------
 Native Android and iOS mobile applications
 Voice input and output for accessibility
 Personalized technique recommendations
 Private digital journaling module
 Goal setting and progress tracking

LONG-TERM (1-2 years):
---------------------
 Offline mode with cached techniques
 Professional portal for psychologists
 Support for Pashto, Sindhi, Punjabi, Balochi
 Fine-tuned local LLM for Pakistani context
 Integration with Sehat Sahulat Program

================================================================================
                          ACKNOWLEDGEMENTS
================================================================================

[1] Google Gemini API - For providing AI conversation capabilities
[2] Taskeen Health Initiative - Mental health awareness in Pakistan
[3] Umang Helpline - 24/7 crisis support in Pakistan
[4] Humraaz Helpline (1166) - Government mental health support
[5] Woebot Health - Inspiration for mental health chatbots
[6] Wysa - Reference for empathetic AI design

================================================================================
                          DISCLAIMER
================================================================================

LLUMA is an AI-based emotional support assistant and NOT a licensed clinical
psychologist. This platform is intended for individuals who are 16 years or
older for safe and responsible use.

If you are experiencing a mental health emergency, severe depression, or
suicidal thoughts, please immediately contact a licensed mental health
professional or call a crisis helpline:

    Umang Helpline (24/7):    +923117786264
    Humraaz Govt Helpline:    1166

LLUMA does not provide medical diagnoses, prescribe medications, or replace
professional psychological treatment. Always seek the advice of qualified
health providers with any questions regarding a medical or mental health
condition.

================================================================================
                          CONTACT INFORMATION
================================================================================

For questions, suggestions, or collaboration opportunities:

Project Supervisor: [Ms Ayesha Butt (Lecturer) ]
Developer 1:        [Muhammad Sarim Khan]
Email:              [Sarimkhanzai0@gmail.com]
Developer 2:        [Syed Muhammad Hamza Shah]
Email:              [syedhamzashah987@gmail.com]
Institution:        [Szabist University Hyderabad Campus]

================================================================================
                          LICENSE
================================================================================

This project is licensed under the MIT License - see the LICENSE file for details.

================================================================================
                          VERSION HISTORY
================================================================================

Version 1.0 - June 2026
    - Initial release
    - AI chatbot with Gemini API
    - Crisis detection with helpline redirection
    - Fallback technique library
    - Four multimedia therapy galleries
    - Mood tracking feature
    - User authentication system

================================================================================
                          END OF README
================================================================================