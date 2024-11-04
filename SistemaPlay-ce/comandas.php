<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Comandas</h1>
        <form id="comandasForm" method="post" action="salvar_comandas.php">
            <div class="comandas">
                <?php
                   for ($i = 1; $i <= 10; $i++) {
                        echo '<button type="button"><a href="cardapio.html">Comanda ' . $i . '</a></button>';
                    }
                ?>
            </div>
        </form>
    </div>
</body>
</html>