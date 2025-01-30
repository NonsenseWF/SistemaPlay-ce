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
        <form id="comandasForm" method="post" action="salvar_pedido.php">
            <div class="comandas">
                <?php
                   for ($i = 1; $i <= 10; $i++) {
                    echo '<button type="button"><a href="cardapio.html">Comanda ' . $i . '</a></button>';
                        //echo '<button type="button"><a href="cardapio.html">New comanda </a></button>';
                    }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
