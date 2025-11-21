<?php
$correctPin = "rootAdmin77";

if ($_POST["pin"] === $correctPin) {
    header("Location: admin.php");
    exit();
} else {
    echo "Incorrect PIN. <a href='index.php'>Go back</a>";
}
?>
