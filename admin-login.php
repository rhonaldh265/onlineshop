<?php
$correctPin = "rootAdmin77";

if ($_POST["pin"] === $correctPin) {
    header("Location: admin.php");
    exit();
} else {
    echo "Incorrect PIN. <a href='admin-login.html'>Try again</a>";
}
?>
