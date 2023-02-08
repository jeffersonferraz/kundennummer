<?php
// CustomerHandle - Klasse einbinden
include_once ("CustomerHandle.php");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premiumkunden</title>
</head>
<body>

    <h1>Kundennummer Generator</h1>

    <h3>Hier erhalten Sie Ihre Premiumkundennummer</h3>

    <form method="post" autocomplete="off">

        <input type="text" name="first_name" placeholder="Vorname" required>
        <input type="text" name="last_name" placeholder="Nachname" required>

        <input type="submit" name="submit_button" value="Generieren">

    </form>

    <?php

        if (isset($_POST['submit_button'])) { 

        $customer = new CustomerHandle;
        $customer->connectDb();

        $customerId = $customer->generateId();
        
        $compareId = $customer->checkId($customerId);

        while(!empty($compareId)) {
            $customerId = $customer->generateId();
            $compareId = $customer->checkId($customerId);
        }

        $customer->insert($customerId, $_POST["first_name"], $_POST["last_name"]);

        }
    ?>

</body>
</html>