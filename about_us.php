<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Railway Community Forum</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .about-header {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('image/railway-background.jpg') no-repeat center center/cover;
            height: 220px;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: left;
            padding: 0 10%;
        }

        .about-header h1 {
            font-size: 3.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .about-section {
            padding: 60px 10%;
            background-color: #fff;
        }

        .about-section h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .about-content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: space-between;
        }

        .about-card {
            background: #f3d487;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33% - 20px);
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .about-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .about-card i {
            font-size: 3rem;
            color: #007BFF;
            margin-bottom: 20px;
        }

        .about-card h3 {
            font-size: 1.8rem;
            margin: 10px 0;
            color: #333;
        }

        .about-card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
        }

        .team-section {
            background-color: #f3f3f3;
            padding: 60px 10%;
        }

        .team-section h2 {
            font-size: 2.2rem;
            margin-bottom: 40px;
        }

        .team-members {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .team-member {
            flex: 1 1 calc(33% - 20px);
            text-align: center;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-member:hover img {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .team-member h4 {
            margin: 10px 0 5px;
            color: #333;
        }

        .team-member p {
            color: #666;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="about-header">
        <h1>About the Railway Community Forum</h1>
    </div>

    <section class="about-section">
        <h2>Who We Are</h2>
        <p>
            The Railway Community Forum is a vibrant platform designed to bring together railway enthusiasts from around the world. Our mission is to foster a thriving community where individuals can share their knowledge, ideas, and experiences related to the fascinating world of railways.
        </p><br>
        <div class="about-content">
            <div class="about-card">
                <i class="fas fa-train"></i>
                <h3>Our Vision</h3>
                <p>To connect railway enthusiasts across the globe through engaging and insightful discussions, inspiring a deeper appreciation for the industry.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-users"></i>
                <h3>Our Community</h3>
                <p>We are proud of our diverse community, which includes professionals, hobbyists, and passionate railway lovers who come together to share their love for all things railway-related.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-globe"></i>
                <h3>Our Mission</h3>
                <p>To provide a safe, informative, and interactive platform where railway enthusiasts can connect, learn, and contribute to the growth and evolution of the industry.</p>
            </div>
        </div>
    </section>

    <section class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-members">
            <div class="team-member">
                <img src="image/cat1.jpg" alt="Team Member 1">
                <h4>John Doe</h4>
                <p>Founder & CEO</p>
            </div>
            <div class="team-member">
                <img src="image/cat2.jpg" alt="Team Member 2">
                <h4>Jane Smith</h4>
                <p>Community Manager</p>
            </div>
            <div class="team-member">
                <img src="image/cat3.jpeg" alt="Team Member 3">
                <h4>Ali Zain</h4>
                <p>Technical Lead</p>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>