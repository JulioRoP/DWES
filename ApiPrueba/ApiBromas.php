<?php
$Numerobromas = 5;
$Arraybromas = [];
for ($i = 0; $i < $Numerobromas; $i++) {
    $url = "https://api.chucknorris.io/jokes/random";
    $response = file_get_contents($url);
    if ($response !== false) {
        $data = json_decode($response, true);
        $Arraybromas[] = $data['value'];
    } else {
        echo "No se pudo obtener la informacion" ;
    }
}
// crear la tabla en el html
echo "<table border='1'>";
foreach ($Arraybromas as $broma) {
    echo "<tr><td>$broma</td></tr>";
}
echo "</table>";
?>
