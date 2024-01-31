<?php
include 'connect.php';

if (isset($_POST['reset-chat'])) {
    if (isset($_POST['confirm-reset']) && $_POST['confirm-reset'] === "yes") {
        $query = "TRUNCATE TABLE chat_messages"; // Hapus semua data chat dari tabel
        $mysqli->query($query);
        header("Location: group_chat.php"); // Redirect kembali ke halaman chat
        exit();
    }
}

if (isset($_POST['sender']) && isset($_POST['message'])) {
    $sender = $_POST['sender'];
    $message = $_POST['message'];

    $query = "INSERT INTO chat_messages (sender, message) VALUES ('$sender', '$message')";
    $mysqli->query($query);

    header("Location: group_chat.php");
    exit();
}

$query = "SELECT * FROM chat_messages ORDER BY timestamp DESC";
$result = $mysqli->query($query);
$chatMessages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chatMessages[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Group Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #00a896;
            /* Warna hijau toska */
        }

        h1 {
            background-color: #005f73;
            /* Warna biru tua */
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .chat-container {
            max-width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .chat-box {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            /* Warna latar belakang chat */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 15px;
            background-color: #d4edda;
            /* Warna bubble chat */
            border: 1px solid #c3e6cb;
        }

        ul li small {
            color: #777;
            font-size: 12px;
        }

        /* Tombol Refresh */
        .refresh-button {
            background-color: #28a745;
            /* Warna hijau toska */
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Styling input dan tombol lainnya */
        input[type="text"],
        select,
        textarea,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #ff6b6b;
            /* Warna merah */
            color: white;
            border: none;
            cursor: pointer;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .form-section {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-group input[type="submit"],
        .form-group button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .form-group button.refresh-button {
            background-color: #28a745;
        }

        .form-group input[type="submit"] {
            background-color: #dc3545;
        }

        .form-group .confirm-reset-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-group .confirm-reset-section label {
            margin: 0;
        }
    </style>
</head>

<body>
    <h1>Group Chat</h1>
    <div class="chat-container">
        <div class="group-name">
            <label for="group-name">Group Name:</label>
            <input type="text" name="group-name" id="group-name" value="AUDEVGROUP" readonly>
        </div>
        <button class="refresh-button" onclick="window.location.reload();">Refresh Chat</button>
        <div class="chat-box">
            <ul>
                <?php foreach ($chatMessages as $message): ?>
                    <li>
                        <strong>
                            <?= $message['sender'] ?>:
                        </strong>
                        <?= $message['message'] ?>
                        <br>
                        <small>
                            <?= $message['timestamp'] ?>
                        </small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <form method="POST">
            <label for="sender">Your Name (Choose):</label>
            <select name="sender">
                <option value="DEVA">DEVA</option>
                <option value="AUDY">AUDY</option>
                <option value="DAD">DAD</option>
                <option value="MOM">MOM</option>
            </select><br>

            <label for="message">Message:</label>
            <textarea name="message" required></textarea><br>

            <input type="submit" value="Send Message">
        </form>

        <form method="POST">
            <input type="submit" name="reset-chat" value="Reset Chat"
                onclick="return confirm('Apakah Anda yakin ingin menghapus semua chat?');"
                style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">

            <!-- Field Konfirmasi Reset Chat -->
            <label for="confirm-reset">Konfirmasi Reset Chat yes/no:</label>
            <input type="radio" name="confirm-reset" value="yes"> Yes
            <input type="radio" name="confirm-reset" value="no" checked> No
        </form>

    </div>
</body>

</html>