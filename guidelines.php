<?php
session_start();
require_once 'database.php';

// Static guidelines (could be replaced or augmented by database-driven content)
$static_guidelines = [
    [
        "title" => "Be Respectful",
        "content" => "Treat all members with kindness and respect. No harassment, hate speech, or discrimination will be tolerated."
    ],
    [
        "title" => "No Spam",
        "content" => "Avoid posting irrelevant or repetitive content. Ensure your contributions add value to the community."
    ],
    [
        "title" => "Follow the Law",
        "content" => "Share content that complies with all applicable laws and regulations. Illegal activities are strictly prohibited."
    ],
    [
        "title" => "Privacy Matters",
        "content" => "Respect the privacy of others. Do not share personal information without consent."
    ],
    [
        "title" => "Constructive Feedback",
        "content" => "Provide feedback that is constructive and aimed at improving the community."
    ],
];

// Recent updates (example data)
$recent_updates = [
    "2024-12-20: Added new rule about spam prevention.",
    "2024-11-15: Clarified the privacy policy guidelines.",
    "2024-10-01: Updated the code of conduct to reflect inclusivity goals."
];

// Example scenarios
$example_scenarios = [
    [
        "scenario" => "John posts offensive comments targeting another member.",
        "outcome" => "John's account is suspended for violating the 'Be Respectful' guideline."
    ],
    [
        "scenario" => "Alice shares a helpful tutorial on the community board.",
        "outcome" => "Alice's post is featured in Community Highlights for its value."
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Guidelines</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .guidelines-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        .guideline {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .guideline:last-child {
            border-bottom: none;
        }
        .guideline h2 {
            font-size: 1.5rem;
            color: #0056b3;
        }
        .guideline p {
            font-size: 1rem;
            color: #555;
        }
        .recent-updates, .example-scenarios {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .recent-updates ul, .example-scenarios ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .acknowledgment {
            margin-top: 20px;
            text-align: center;
        }
        .acknowledgment button {
            padding: 10px 15px;
            background-color: #0056b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .acknowledgment button:hover {
            background-color: #003f8a;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?> <!-- Optional: Include navigation menu -->

    <div class="guidelines-container">
        <h1>Community Guidelines</h1>
        <?php foreach ($static_guidelines as $guideline): ?>
            <div class="guideline">
                <h2><?= htmlspecialchars($guideline['title']); ?></h2>
                <p><?= nl2br(htmlspecialchars($guideline['content'])); ?></p>
            </div>
        <?php endforeach; ?>

         <!-- Recent Updates Section -->
         <div class="recent-updates">
            <h2>Recent Updates</h2>
            <ul>
                <?php foreach ($recent_updates as $update): ?>
                    <li><?= htmlspecialchars($update); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Example Scenarios Section -->
         <div class="example-scenarios">
            <h2>Example Scenarios</h2>
            <ul>
                <?php foreach ($example_scenarios as $scenario): ?>
                    <li>
                        <strong>Scenario:</strong> <?= htmlspecialchars($scenario['scenario']); ?><br>
                        <strong>Outcome:</strong> <?= htmlspecialchars($scenario['outcome']); ?>
                    </li>
                <?php endforeach; ?>
             </ul>
          </div>

        <!-- Acknowledgment Section -->
        <div class="acknowledgment">
            <p>Please acknowledge that you have read and understood the guidelines.</p>
            <button onclick="alert('Thank you for acknowledging our community guidelines!')">Acknowledge</button>
        </div>
    </div>

    <?php include 'footer.php'; ?> 
</body>
</html>
