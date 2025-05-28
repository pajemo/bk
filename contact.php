<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Pajmeo Bank</title>
    <link rel="stylesheet" href="style_theme_update.css">
    <style>
        .content {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: rgb(139, 55, 111);
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }
        input[type="submit"] {
            margin-top: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: rgb(159, 102, 141);
        }
        .contact-info {
            margin-top: 30px;
            font-size: 1.1em;
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            color: rgb(139, 55, 111);
        }
        .contact-info p {
            margin: 0;
            width: 33%;
        }
        .contact-info p:first-child {
            text-align: left;
        }
        .contact-info p:nth-child(2) {
            text-align: center;
        }
        .contact-info p:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Contact Us</h1>
        <form method="post" action="contact.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <input type="submit" value="Send Message">
        </form>

        <div class="contact-info">
            
        </div>
    </div>

<?php include 'footer.php'; ?>
</body>
</html>
