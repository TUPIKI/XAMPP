<?php
$servername = 'localhost';
$username = "noskilr";
$password = "rlikson";
$database = "antiskilr";

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

?>

<body>
    <header>
	    <link rel="stylesheet" type="text/css" href="style.css"/>

        <th>LISTE DE CVE</th>

    </header>

	<div class="search-box">
        <input class="search" type="Search" placeholder="Search">
        <select name="CVE" id="CVE">
            <option value="ID">ID</option>
            <option value="NAME">NOM</option>
            <option value="VICTIME">VICT</option>
            <option value="audi">VULN</option>
        </select>
    </div>

<table>

    <tr>
        <th>id</th>
        <th>nom</th>
        <th>victime</th>
        <th>vulnerabilite</th>
    </tr>

    <?php
    $conn = mysqli_connect($servername, $username, $password, $database);
    $requete = mysqli_query($conn, "SELECT id, name, victime, vuln FROM Cve");
    if($requete) {
        for ($i=0; $i < mysqli_num_rows($requete); $i++) {
            $ligne = mysqli_fetch_array($requete, MYSQLI_ASSOC);
            echo "<tr>
                    <td>" . $ligne["id"] . "</td>
                    <td>" . $ligne["name"] . "</td>
                    <td>" . $ligne["victime"] . "</td>
                    <td>" . $ligne["vuln"] . "</td>
            </tr>";
        }
    }
    mysqli_close($conn);
    ?>
</table>
</body>