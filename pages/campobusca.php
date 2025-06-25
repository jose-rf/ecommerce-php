<?php 
include ("../includes/db.php");
?>

<form method="GET" action="campobusca.php">
    <input type="text" name="busca" placeholder="Buscar produtos..." required>
    <button type="submit">Buscar</button>
</form>

<?php
    if(isset($_GET ['busca']) && $_GET['busca'] != ''){
        $termo = $conn -> real_escape_string($_GET ['busca']);

        $sql = "SELECT * FROM produtos WHERE nome LIKE '%$termo%'";
        $result = $conn -> query($sql);

        echo"<h2> Resultados para: <em>$termo</em></h2>";

        if($result->num_rows > 0){
            while($produto = $result -> fetch_assoc()){ 
                echo "<div>";
                echo "<h3>" . $produto ['nome'] . "</h3>";
                echo "<p> Preço: R$" . $produto ['preco'] . "</p>";
                echo "</div>";
    }
        } else{
            echo "Nenhum produto encontrado :(";
        }
}


?>