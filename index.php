<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="flex-container">
            <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/6u3DKwLBRMc?si=KZgykCKCej1nrzNj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                <form action="index.php" method="post">
                    Name: <input type="text" name="name"><br>
                    Email: <input type="email" name="emailRequest"><br>
                    Comment: <textarea name="comment"></textarea><br>
                    <input type="submit" value="Submit"> 
                </form>
            </div>
        </div>
    </div>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "comments";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected";


    $sql = "SELECT id, name, date, email, comment FROM comment";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - name: " . $row["name"] . " " . $row["email"] . "<br>" . $row["comment"] . "<br>";
        }
    } else {
        echo "0 results";
    }

    // Post request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        if (empty($name)) {
            echo "Name is empty";
        } else {
            echo "<br>" . $name . ": <br>";
        }
        $commentText = $_POST['comment'];
        if (empty($commentText)) {
            echo "comment is empty";
        } else {
            echo $commentText;
        }
        $emailRequest = $_POST['emailRequest'];
        if (empty($emailRequest)) {
            echo "email is empty";
        } else {
            echo "<br>" . $emailRequest;
        }

        $sql = "INSERT INTO comment (name, comment, email)
        VALUES ('$name', '$commentText', '$emailRequest ')";

        if ($conn->query($sql)) {
            echo "<br>Posted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>

</html>