<?php
// session_start();
// require_once 'database.php';

?>
<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<body>
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
<?php include basePath('ui/partials/footer.php'); ?>