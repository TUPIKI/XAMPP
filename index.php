<?php
$servername = 'localhost';
$username = "noskilr";
$password = "rlikson";
$database = "antiskilr";

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

$recherche = "";
if(isset($_GET["q"])) {
    $recherche = trim($_GET["q"]);
}

$champ = "tout";
if(isset($_GET["champ"])) {
    $champ = $_GET["champ"];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Liste de CVE</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div class="uc-top">
    <div class="uc-wrap">
        <div class="uc-logo">LISTE DE <em>CVE</em></div>
    </div>
</div>

<div class="uc-wrap">
    <div class="uc-body">

        <div class="tcat">Base de données CVE</div>

        <form method="get" action="index.php" class="uc-bar">
            <span class="lbl">Rechercher :</span>
            <input class="uc-input" type="search" name="q" value="<?php echo $recherche; ?>" placeholder="Search" size="34">
            <select class="uc-input" name="champ">
                <option value="tout" <?php if($champ == "tout") { echo "selected"; } ?>>Tout</option>
                <option value="id" <?php if($champ == "id") { echo "selected"; } ?>>ID</option>
                <option value="name" <?php if($champ == "name") { echo "selected"; } ?>>Nom</option>
                <option value="victime" <?php if($champ == "victime") { echo "selected"; } ?>>Victime</option>
                <option value="vuln" <?php if($champ == "vuln") { echo "selected"; } ?>>Vulnérabilité</option>
            </select>
            <button class="uc-btn primary" type="submit">Filtrer</button>
            <a class="uc-btn" href="index.php">Réinitialiser</a>
        </form>

        <table class="uc-table">
            <thead>
                <tr>
                    <th class="uc-id">id</th>
                    <th class="uc-name">nom</th>
                    <th class="uc-victim">victime</th>
                    <th class="uc-vuln">vulnerabilite</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT id, name, victime, vuln FROM Cve";

            if($recherche != "") {
                $safe = mysqli_real_escape_string($conn, $recherche);

                if($champ == "id") {
                    $sql = $sql . " WHERE id = '" . $safe . "'";
                } elseif($champ == "name") {
                    $sql = $sql . " WHERE name LIKE '%" . $safe . "%'";
                } elseif($champ == "victime") {
                    $sql = $sql . " WHERE victime LIKE '%" . $safe . "%'";
                } elseif($champ == "vuln") {
                    $sql = $sql . " WHERE vuln LIKE '%" . $safe . "%'";
                } else {
                    $sql = $sql . " WHERE name LIKE '%" . $safe . "%' OR victime LIKE '%" . $safe . "%' OR vuln LIKE '%" . $safe . "%'";
                }
            }

            $requete = mysqli_query($conn, $sql);
            if($requete) {
                $nombre = mysqli_num_rows($requete);

                if($nombre == 0) {
                    echo "<tr class=\"uc-empty\"><td colspan=\"4\">Aucune entrée trouvée.</td></tr>";
                }

                for ($i=0; $i < $nombre; $i++) {
                    $ligne = mysqli_fetch_array($requete, MYSQLI_ASSOC);
                    echo "<tr>
                            <td class=\"uc-id\"><span class=\"rowicon\"></span><a href=\"#\">#" . $ligne["id"] . "</a></td>
                            <td class=\"uc-name\"><a href=\"#\">" . htmlspecialchars($ligne["name"]) . "</a></td>
                            <td class=\"uc-victim\">" . htmlspecialchars($ligne["victime"]) . "</td>
                            <td class=\"uc-vuln\"><span class=\"vuln\">" . htmlspecialchars($ligne["vuln"]) . "</span></td>
                    </tr>";
                }
            }
            mysqli_close($conn);
            ?>
            </tbody>
        </table>

        <div class="uc-legend">
            <div class="uc-box">
                <div class="tcat">Légende</div>
                <div class="body">
                    <div class="leg-row"><span class="vuln crit">RCE</span><span>exécution de code</span></div>
                    <div class="leg-row"><span class="vuln med">SQLi</span><span>injection SQL</span></div>
                    <div class="leg-row"><span class="vuln low">Info</span><span>divulgation</span></div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="uc-spacer"></div>

</body>
</html>
