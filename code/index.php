<!---------------------------------------------------------------------
  coding:       utf-8
  Anwendung:    Kundennummer-Generator
  Autor:        Ferraz / Pophof
  Datum:        22.02.2023
  Version:      1.0
---------------------------------------------------------------------->

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
        // CustomerHandle-Klasse einbinden
        include_once ("CustomerHandle.php");

        // if-Statement wird aktiviert beim Anklicken des Buttons
        if (isset($_POST['submit_button'])) {

        // Ein Objekt wird von der Klasse CustomerHandle instanziert
        $customer = new CustomerHandle;

        // Die Kundennummer wird durch generateId()-Methode erstellt
        $customerId = $customer->generateId();
        
        // Die Kundennummer wird durch checkId()-Methode auf die Einzigartigkeit geprüft
        $compareId = $customer->checkId($customerId);

        // Solange die Kundennummer nicht einzigartig ist, wird eine neue generiert
        while(!empty($compareId)) {
            $customerId = $customer->generateId();
            $compareId = $customer->checkId($customerId);
        }

        // Die Kundendaten werden durch insert()-Methode in die DB gespeichert
        $customer->insert($customerId, $_POST["first_name"], $_POST["last_name"]);

        }
    ?>

</body>
</html>