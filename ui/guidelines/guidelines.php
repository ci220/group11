<?php

$title = "Community Guidelines";
$css = ["css/styles.css", "css/guidelines.css"];

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

require 'guidelines_view.php';