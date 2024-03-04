<!DOCTYPE html>
<html>
<head>
    <title>Gestione Ordinazioni</title>
</head>
<body>

<h2>Inserimento Ordinazioni</h2>
<form method="post">
    Prodotto:
    <select name="idProdotto">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "esercizio_bar";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }

        $sql = "SELECT IDProdotto, Nome FROM Prodotti";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row["IDProdotto"]."'>".$row["Nome"]."</option>";
            }
        } else {
            echo "<option value=''>Nessun prodotto trovato</option>";
        }

        $conn->close();
        ?>
    </select><br><br>
    Cameriere:
    <select name="idCameriere">
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }

        $sql = "SELECT IDCameriere, Nome FROM Camerieri";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row["IDCameriere"]."'>".$row["Nome"]."</option>";
            }
        } else {
            echo "<option value=''>Nessun cameriere trovato</option>";
        }

        $conn->close();
        ?>
    </select><br><br>
    Quantità: <input type="number" name="quantita" required><br><br>
    <input type="submit" value="Inserisci Ordinazione">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $idProdotto = $_POST["idProdotto"];
    $idCameriere = $_POST["idCameriere"];
    $quantita = $_POST["quantita"];
    $stato = "in attesa";

    $sql = "INSERT INTO Ordinazioni (IDProdotto, IDCameriere, quantità, Stato, DataOra)
            VALUES ($idProdotto, $idCameriere, $quantita, '$stato', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Ordinazione inserita con successo.";
    } else {
        echo "Errore durante l'inserimento dell'ordinazione: " . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>
