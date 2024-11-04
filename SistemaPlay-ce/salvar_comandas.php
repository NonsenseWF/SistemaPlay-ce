<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Playce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comandas = $_POST['comanda'];

    foreach ($comandas as $num_comanda => $comanda) {
        $observacoes = $conn->real_escape_string($comanda['observations']);

        // Inserir cada item da comanda
        if (isset($comanda['items'])) {
            foreach ($comanda['items'] as $index => $item) {
                $quantidade = (int) $comanda["quantity" . ($index + 1)];
                
                $sql = "INSERT INTO comandas (comanda_numero, item, quantidade, observacoes) 
                        VALUES ('$num_comanda', '$item', '$quantidade', '$observacoes')";

                if (!$conn->query($sql)) {
                    echo "Erro ao inserir dados: " . $conn->error;
                }
            }
        }
    }

    echo "Comandas salvas com sucesso!";
}

$conn->close();
?>
