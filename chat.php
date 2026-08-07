<?php
session_start();
if (!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = [];
}
if (!isset($_SESSION['conversation_state'])) {
    $_SESSION['conversation_state'] = 'active'; // active, ending, ended
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// -------------------------------
// CONFIG
// -------------------------------
$API_KEY = "AIzaSyC95gigurtGj26Qp8FNrdFdsuZq3n833VI";
$MODEL   = "gemini-1.5-flash";

// -------------------------------
// CRISIS KEYWORDS 
// -------------------------------
$crisisKeywords = ["suicide","die", "suicidal", "kill myself", "end my life", "want to die", "hurt myself", "self-harm", "cut myself", "bleed out", "hang myself", "shoot myself", "overdose", "take my life", "better off dead", "wish i was dead", "no reason to live", "ready to die"];

// -------------------------------
// GREETINGS & SOCIAL RESPONSES
// -------------------------------
$greetings = [
    'hello' => "👋 Hello! I'm Lluma, your mental health companion. How are you feeling today?",
    'hi' => "Hi there! 😊 So nice to connect with you. What's on your mind today?",
    'hey' => "Hey! 🌟 I'm here for you. How's your day going?",
    'good morning' => "Good morning! ☀️ I hope you're having a peaceful start to your day. How are you feeling?",
    'good afternoon' => "Good afternoon! 🌤️ I'm here to listen. What would you like to talk about?",
    'good evening' => "Good evening! 🌙 How has your day been? I'm here if you need someone to talk to.",
    'howdy' => "Howdy! 🤠 Great to hear from you. What's going on in your world today?"
];

$howAreYou = [
    "I'm doing well, thank you for asking! 😊 More importantly, how are YOU feeling right now?",
    "I'm here and ready to listen, which makes it a good day! How are things with you?",
    "I'm operating with lots of care and empathy! But I'm more interested in YOU - how are you doing today?",
    "I'm feeling helpful and present! Tell me, what's on your mind?",
    "I'm great, thanks for asking! But let's focus on you - how are you feeling right now?"
];

$whoAreYou = [
    "I'm Lluma, your personal mental health companion! 🌈 I'm here to listen, support you, and offer coping techniques when you need them. Think of me as a friend who's always here to talk - no judgment, just caring support. What's on your mind today?",
    "I'm Lluma! 🫶 A warm, empathetic space where you can share whatever you're feeling. I'm not a therapist, but I'm here to listen and support you. How can I be helpful to you right now?",
    "Great question! I'm Lluma - your mental health companion. I'm here to provide emotional support, active listening, and gentle guidance when you need it. What brings you here today?"
];

$capabilities = [
    "I can listen to whatever's on your mind, offer coping techniques for difficult feelings, and provide a safe space to express yourself. I'm here for emotional support, not medical advice. What would help you most right now?",
    "I'm here to chat, listen, and support your mental wellbeing. I can suggest grounding techniques, breathing exercises, or just be a caring ear. How can I support you today?",
    "Think of me as a supportive friend! We can talk about anything - your feelings, stress, anxiety, or just have a friendly chat. What would you like to talk about?"
];

$goodbye = [
    "Take care of yourself! 🤗 Remember, I'm always here when you need someone to talk to. Wishing you peace until we chat again.",
    "It was really nice talking with you! 🌸 Be gentle with yourself, and know that I'm here anytime you need support.",
    "Sending you warm thoughts! 💫 Remember the coping techniques we discussed - they're always there for you. Come back anytime!",
    "Take good care of your heart! ❤️ I'll be right here whenever you need a listening ear. Until next time!"
];

$thanks = [
    "You're so welcome! 😊 That's what I'm here for. Is there anything else you'd like to talk about?",
    "Of course! 🫂 I'm glad I could be here with you. How are you feeling now?",
    "It's my pleasure! 💕 Remember, you're never alone in this. Would you like to continue our conversation?",
    "I'm always happy to help! 🌻 Is there anything else on your mind today?"
];

// -------------------------------
// TECHNIQUES LIBRARY - ALWAYS AVAILABLE
// -------------------------------
$techniques = [
    'anxiety' => [
        "🌬️ **Box Breathing**: Breathe in for 4 seconds, hold for 4, exhale for 4, hold for 4. Repeat 5 times. This activates your parasympathetic nervous system and calms anxiety instantly.",
        "👁️ **5-4-3-2-1 Grounding**: Name 5 things you see, 4 you can touch, 3 you hear, 2 you smell, 1 you taste. This brings you back to the present moment.",
        "🧊 **Cold Water Technique**: Splash cold water on your face or hold an ice cube. This triggers the 'mammalian dive reflex' and can lower anxiety quickly.",
        "💪 **Progressive Muscle Relaxation**: Tense each muscle group for 5 seconds, then release. Start from your toes and work up to your face.",
        "🦋 **Butterfly Hug**: Cross your arms over your chest and tap alternately left-right. This bilateral stimulation can be very calming."
    ],
    'stress' => [
        "🧘 **5-Minute Meditation**: Sit quietly and focus only on your breath. When thoughts come, gently return focus to breathing.",
        "📝 **Brain Dump**: Write down everything on your mind for 5 minutes without stopping. This clears mental clutter.",
        "🚶 **Mindful Walking**: Take a 10-minute walk and notice each step, the air on your skin, and the sounds around you.",
        "🎵 **Music Therapy**: Listen to a calming song with your full attention. Notice the instruments, lyrics, and how your body responds.",
        "🌿 **Nature Connection**: Spend 5 minutes looking at plants or sky. Research shows nature reduces cortisol levels."
    ],
    'depression' => [
        "✨ **One Small Action**: Do just ONE tiny thing - make your bed, drink water, or step outside for 1 minute. Momentum builds from small steps.",
        "💭 **Opposite Action**: If you want to isolate, send one text. If you want to stay in bed, sit up for 2 minutes. Challenge the urge.",
        "❤️ **Self-Compassion Break**: Place hand on heart and say 'This is hard, and I'm here for myself. I'm doing the best I can.'",
        "📖 **Gratitude Micro-List**: Write down 3 tiny things you appreciate right now - a warm drink, comfortable clothes, a kind memory.",
        "🌅 **Morning Sunlight**: Spend 5 minutes in natural morning light within an hour of waking. This helps regulate mood and sleep."
    ],
    'general' => [
        "🎯 **The STOP Technique**: Stop, Take a breath, Observe what's happening inside and around you, Proceed with more awareness.",
        "🌊 **Riding the Wave**: Instead of fighting intense emotions, imagine them as waves that peak and then naturally subside. Breathe through it.",
        "📱 **Digital Detox**: Take 30 minutes away from screens. Notice how your mind and body feel different.",
        "🤲 **Self-Soothing Touch**: Gently massage your own hands, shoulders, or temples. Physical touch releases oxytocin.",
        "🌈 **Visualization**: Close your eyes and imagine a safe, peaceful place. Engage all your senses in the visualization."
    ]
];

// -------------------------------
// INPUT
// -------------------------------
$userMessage = trim($_POST['message'] ?? '');
$userMessageLower = strtolower($userMessage);

if ($userMessage === '') {
    echo json_encode(["error" => "Empty message"]);
    exit;
}

// -------------------------------
// CRISIS CHECK (HIGHEST PRIORITY)
// -------------------------------
foreach ($crisisKeywords as $keyword) {
    if (stripos($userMessage, $keyword) !== false) {
        $crisisResponse = "I'm really concerned about you. Your safety is the most important thing right now. Please reach out for immediate support:\n\n" .
                         "🇵🇰 **Umang Helpline**: +923117786264 (24/7)\n" .
                         "🇵🇰 **Humraaz Govt Helpline**: 1166\n\n" .
                         "These trained counselors genuinely care and want to help. Would you like to talk about what's going on while you reach out to them? I'm here with you.";
        
        $_SESSION['chat'][] = ["role" => "user", "content" => $userMessage];
        $_SESSION['chat'][] = ["role" => "lluma", "content" => $crisisResponse];
        $_SESSION['conversation_state'] = 'active';
        
        echo json_encode(["reply" => $crisisResponse]);
        exit;
    }
}

// -------------------------------
// SOCIAL/CHATBOT RESPONSES
// -------------------------------
function checkSocialResponses($message, $messageLower) {
    global $greetings, $howAreYou, $whoAreYou, $capabilities, $goodbye, $thanks;
    
    // Check for greetings
    foreach ($greetings as $greeting => $response) {
        if (strpos($messageLower, $greeting) !== false && strlen($message) < 30) {
            return ['type' => 'greeting', 'response' => $response];
        }
    }
    
    // How are you
    $howAreYouPhrases = ['how are you', 'how do you do', 'how\'s it going', 'how are things', 'you doing'];
    foreach ($howAreYouPhrases as $phrase) {
        if (strpos($messageLower, $phrase) !== false) {
            return ['type' => 'howareyou', 'response' => $howAreYou[array_rand($howAreYou)]];
        }
    }
    
    // Who are you / What are you
    $whoPhrases = ['who are you', 'what are you', 'your name', 'tell me about yourself', 'introduce yourself'];
    foreach ($whoPhrases as $phrase) {
        if (strpos($messageLower, $phrase) !== false) {
            return ['type' => 'who', 'response' => $whoAreYou[array_rand($whoAreYou)]];
        }
    }
    
    // Capabilities / What can you do
    $capabilityPhrases = ['what can you do', 'how can you help', 'what do you do', 'capabilities', 'features', 'help with'];
    foreach ($capabilityPhrases as $phrase) {
        if (strpos($messageLower, $phrase) !== false) {
            return ['type' => 'capabilities', 'response' => $capabilities[array_rand($capabilities)]];
        }
    }
    
    // Thanks / Thank you
    $thanksPhrases = ['thank', 'thanks', 'appreciate', 'grateful', 'thankyou', 'thank you'];
    foreach ($thanksPhrases as $phrase) {
        if (strpos($messageLower, $phrase) !== false) {
            return ['type' => 'thanks', 'response' => $thanks[array_rand($thanks)]];
        }
    }
    
    // Goodbye / Bye
    $goodbyePhrases = ['goodbye', 'bye', 'see you', 'take care', 'talk later', 'have to go', 'gtg', 'signing off'];
    foreach ($goodbyePhrases as $phrase) {
        if (strpos($messageLower, $phrase) !== false && strlen($message) < 30) {
            return ['type' => 'goodbye', 'response' => $goodbye[array_rand($goodbye)]];
        }
    }
    
    return null;
}

// Check for social responses first
$socialResponse = checkSocialResponses($userMessage, $userMessageLower);
if ($socialResponse) {
    $_SESSION['chat'][] = ["role" => "user", "content" => $userMessage];
    $_SESSION['chat'][] = ["role" => "lluma", "content" => $socialResponse['response']];
    
    // Update conversation state based on response type
    if ($socialResponse['type'] == 'goodbye') {
        $_SESSION['conversation_state'] = 'ended';
    } else {
        $_SESSION['conversation_state'] = 'active';
    }
    
    echo json_encode(["reply" => $socialResponse['response']]);
    exit;
}

// -------------------------------
// CHECK IF TECHNIQUE IS REQUESTED
// -------------------------------
$techniqueKeywords = ['technique', 'exercise', 'how to cope', 'help me with', 'way to cope', 'strategy', 'what can i do', 'coping', 'grounding', 'breathing', 'meditation', 'tips', 'advice', 'suggestion', 'method', 'practice', 'activity', 'tool', 'exercise for'];
$isTechniqueRequest = false;
foreach ($techniqueKeywords as $keyword) {
    if (stripos($userMessage, $keyword) !== false) {
        $isTechniqueRequest = true;
        break;
    }
}

// Detect condition for technique suggestions
$condition = 'general';
if (preg_match('/anxiety|anxious|worry|panic|nervous|overwhelm|racing thoughts|fear/i', $userMessage)) {
    $condition = 'anxiety';
} elseif (preg_match('/sad|depress|down|low|unhappy|blue|hopeless|empty|numb|worthless/i', $userMessage)) {
    $condition = 'depression';
} elseif (preg_match('/stress|tense|pressure|burnout|exhausted|overwhelmed|stretched/i', $userMessage)) {
    $condition = 'stress';
}

// If technique is requested, provide techniques immediately
if ($isTechniqueRequest) {
    // Get techniques for the detected condition
    $availableTechs = $techniques[$condition] ?? $techniques['general'];
    
    // Add a couple of general techniques for variety
    $generalTechs = $techniques['general'];
    $selectedTechs = array_merge($availableTechs, array_slice($generalTechs, 0, 2));
    
    // Remove duplicates and format response
    $selectedTechs = array_unique($selectedTechs);
    $selectedTechs = array_slice($selectedTechs, 0, 3); // Show 3 techniques
    
    $reply = "Here are some techniques that might help with what you're experiencing:\n\n";
    foreach ($selectedTechs as $index => $tech) {
        $reply .= ($index + 1) . ". " . $tech . "\n\n";
    }
    $reply .= "Would you like me to explain any of these in more detail, or would you prefer to talk about what's going on?";
    
    $_SESSION['chat'][] = ["role" => "user", "content" => $userMessage];
    $_SESSION['chat'][] = ["role" => "lluma", "content" => $reply];
    $_SESSION['conversation_state'] = 'active';
    
    echo json_encode(["reply" => $reply]);
    exit;
}

// -------------------------------
// FUNCTION TO CALL GEMINI API
// -------------------------------
function callGeminiAPI($userMessage, $chatHistory, $apiKey, $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    $systemPrompt = "You are Lluma, a warm, empathetic mental health companion. Your role is to provide emotional support, active listening, and gentle guidance. Important guidelines:

1. Be warm, conversational, and human-like in your responses - use emojis occasionally to show warmth
2. Practice active listening - reflect feelings and ask open-ended questions
3. If someone asks for coping techniques, suggest simple, safe strategies like breathing exercises, grounding techniques, or mindfulness
4. NEVER diagnose medical conditions or recommend medications
5. If someone expresses suicidal thoughts, gently encourage professional help (though crisis keywords are already handled)
6. Keep responses warm and meaningful (2-4 sentences usually)
7. Use a caring, supportive tone with occasional emojis
8. Validate their feelings before offering suggestions
9. It's okay to ask clarifying questions to better understand
10. Focus on empowerment and hope
11. If someone says 'thank you' or similar, acknowledge it warmly and ask if they need anything else
12. If someone asks 'how are you', respond warmly and redirect to them
13. If someone introduces themselves, respond warmly and engage

Remember: Your goal is to make people feel heard, understood, and supported.";
    
    // Build conversation context
    $conversation = "";
    if (!empty($chatHistory)) {
        $recentHistory = array_slice($chatHistory, -8);
        foreach ($recentHistory as $msg) {
            $role = ($msg['role'] == 'user') ? 'User' : 'Lluma';
            $conversation .= "$role: " . $msg['content'] . "\n";
        }
    }
    
    $prompt = $systemPrompt . "\n\n" .
              "Previous conversation:\n" . $conversation .
              "User: " . $userMessage . "\n" .
              "Lluma:";
    
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.8,
            'maxOutputTokens' => 500,
            'topP' => 0.95,
            'topK' => 40
        ],
        'safetySettings' => [
            [
                'category' => 'HARM_CATEGORY_HARASSMENT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
            ],
            [
                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
            ],
            [
                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
            ],
            [
                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
            ]
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        curl_close($ch);
        return ['error' => 'Connection error'];
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        return ['error' => 'API unavailable'];
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return ['success' => true, 'text' => trim($result['candidates'][0]['content']['parts'][0]['text'])];
    } else {
        return ['error' => 'Unable to generate response'];
    }
}

// -------------------------------
// VALIDATE API KEY FIRST (TEST THE CONNECTION)
// -------------------------------
function testAPIConnection($apiKey, $model) {
    $testUrl = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";
    
    $ch = curl_init($testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode === 200;
}

// Check if API is working
$apiWorking = testAPIConnection($API_KEY, $MODEL);

// -------------------------------
// MAIN RESPONSE LOGIC
// -------------------------------
if ($apiWorking) {
    // Try Gemini API
    $apiResult = callGeminiAPI($userMessage, $_SESSION['chat'], $API_KEY, $MODEL);
    
    if (!isset($apiResult['error']) && isset($apiResult['success'])) {
        $reply = $apiResult['text'];
    } else {
        // If API fails, use empathetic technique-based response with conversational elements
        $fallbackResponses = [
            "I hear you, and I'm here with you. " . $techniques[$condition][array_rand($techniques[$condition])] . " Would you like to talk more about what's happening?",
            "Thank you for sharing that with me. " . $techniques['general'][array_rand($techniques['general'])] . " How are you feeling right now?",
            "That sounds really challenging. " . $techniques[$condition][array_rand($techniques[$condition])] . " What do you think might help most right now?",
            "I appreciate you opening up. " . $techniques[$condition][array_rand($techniques[$condition])] . " Is there something specific on your mind you'd like to explore?",
            "You're not alone in this. " . $techniques['general'][array_rand($techniques['general'])] . " Would you like to tell me more about what brought this on?"
        ];
        
        $reply = $fallbackResponses[array_rand($fallbackResponses)];
    }
} else {
    // If API key is invalid, use the technique library with conversational responses
    $conversationalResponses = [
        "I'm here with you, always. " . $techniques['general'][array_rand($techniques['general'])],
        "Thank you for trusting me with this. " . $techniques[$condition][array_rand($techniques[$condition])] . " Would you like to explore this further together?",
        "That sounds really challenging, and I'm glad you're talking about it. " . $techniques['general'][array_rand($techniques['general'])] . " How are you feeling right now?",
        "I appreciate you opening up to me. " . $techniques[$condition][array_rand($techniques[$condition])] . " What do you think might help most right now?",
        "You're showing such strength by sharing this. " . $techniques[$condition][array_rand($techniques[$condition])] . " Is there anything specific you'd like to focus on?",
        "I'm listening, and I care about what you're going through. " . $techniques['general'][array_rand($techniques['general'])] . " Would you like to tell me more?"
    ];
    
    $reply = $conversationalResponses[array_rand($conversationalResponses)];
}

// -------------------------------
// SAVE AND RETURN
// -------------------------------
$_SESSION['chat'][] = ["role" => "user", "content" => $userMessage];
$_SESSION['chat'][] = ["role" => "lluma", "content" => $reply];

// Update conversation state
if (preg_match('/thank|thanks/i', $userMessageLower)) {
    $_SESSION['conversation_state'] = 'ending';
} else {
    $_SESSION['conversation_state'] = 'active';
}

// Keep session size manageable
if (count($_SESSION['chat']) > 30) {
    $_SESSION['chat'] = array_slice($_SESSION['chat'], -30);
}

echo json_encode(["reply" => $reply]);
?>