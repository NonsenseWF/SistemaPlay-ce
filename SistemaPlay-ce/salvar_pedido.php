<?php
$supabaseUrl = "https://pdlncflmwqnlihdtulor.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InBkbG5jZmxtd3FubGloZHR1bG9yIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzgxNTcwMTMsImV4cCI6MjA1MzczMzAxM30.YYX3mfaGCUZlFXJ2E6402yDbBX4FUigBJZQwa4Q2nP0";

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mesa = $_POST['mesa']; // Número da mesa
    $itens_pedido = $_POST['pedido']; // Itens selecionados pelo garçom

    // Valida se ao menos um item foi selecionado
    if (empty($itens_pedido)) {
        echo "Por favor, selecione ao menos um item do cardápio.";
        exit;
    }

    // Verificar se já existe uma comanda aberta para essa mesa
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $supabaseUrl . "/rest/v1/orders?mesa=eq.$mesa&status=eq.aberta");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $supabaseKey",
        "Content-Type: application/json",
        "apikey: $supabaseKey"
    ]);

    $response = curl_exec($ch);
    $existing_order = json_decode($response, true);

    // Se já existe uma comanda aberta para a mesa, atualiza a comanda com os novos itens
    if (count($existing_order) > 0) {
        $order_id = $existing_order[0]['id']; // ID da comanda existente
        $current_total = $existing_order[0]['total']; // Total atual da comanda

        // Inserir os itens na tabela 'order_items' para a comanda existente
        foreach ($itens_pedido as $item) {
            $item_price = calcularPreco($item); // Preço do item
            $data_item = [
                'order_id' => $order_id, // Referência à comanda existente
                'item_name' => $item, // Nome do item
                'quantity' => 1, // Quantidade de cada item (supondo 1 para simplicidade)
                'price' => $item_price // Preço do item
            ];

            // Configura a requisição cURL para inserir os itens
            curl_setopt($ch, CURLOPT_URL, $supabaseUrl . "/rest/v1/order_items");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_item));
            $response_item = curl_exec($ch);

            // Verifica se houve erro ao inserir o item
            if ($response_item === false) {
                echo "Erro ao adicionar item ao pedido: " . curl_error($ch);
                exit;
            }

            // Atualiza o total da comanda
            $current_total += $item_price;
        }

        // Atualiza o total da comanda
        $data_order_update = [
            'total' => $current_total
        ];

        curl_setopt($ch, CURLOPT_URL, $supabaseUrl . "/rest/v1/orders?id=eq.$order_id");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_order_update));
        $response_update = curl_exec($ch);

        if ($response_update === false) {
            echo "Erro ao atualizar o total da comanda: " . curl_error($ch);
            exit;
        }

        echo "Itens adicionados e total atualizado com sucesso!";
    } else {
        // Caso não exista comanda aberta, cria uma nova
        $data_order = [
            'mesa' => $mesa, // Número da mesa
            'status' => 'aberta', // Status inicial da comanda
            'total' => calcularTotal($itens_pedido), // Total da comanda
            'created_at' => date("Y-m-d H:i:s") // Data de criação da comanda
        ];

        // Inicializa cURL para a requisição da comanda
        curl_setopt($ch, CURLOPT_URL, $supabaseUrl . "/rest/v1/orders");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_order));
        $response_order = curl_exec($ch);
        $order_data = json_decode($response_order, true); // Decodifica a resposta JSON da comanda

        // Verifica se houve erro ao criar a comanda
        if ($response_order === false || isset($order_data['code'])) {
            echo "Erro ao criar a comanda: " . ($order_data['message'] ?? "Erro desconhecido");
            exit;
        }

        // Obtém o ID da comanda criada
        $order_id = $order_data[0]['id']; // A primeira posição do array contém a comanda criada

        // Inserir os itens na tabela 'order_items'
        foreach ($itens_pedido as $item) {
            $data_item = [
                'order_id' => $order_id, // Referência à comanda criada
                'item_name' => $item, // Nome do item
                'quantity' => 1, // Quantidade de cada item (supondo 1 para simplicidade)
                'price' => calcularPreco($item) // Preço do item
            ];

            // Configura a requisição cURL para inserir os itens
            curl_setopt($ch, CURLOPT_URL, $supabaseUrl . "/rest/v1/order_items");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_item));
            $response_item = curl_exec($ch);

            // Verifica se houve erro ao inserir o item
            if ($response_item === false) {
                echo "Erro ao adicionar item ao pedido: " . curl_error($ch);
                exit;
            }
        }

        echo "Pedido registrado com sucesso!";
    }

    // Fecha a conexão cURL
    curl_close($ch);
}

// Função para calcular o total do pedido
function calcularTotal($itens) {
    $precos = [
        'Pizza' => 35.00,
        'Hambúrguer Clássico' => 28.00,
        'Salada' => 22.00,
        'Fritas' => 40.00,
        'Sorvete Artesanal' => 12.00
    ];

    $total = 0;
    foreach ($itens as $item) {
        if (isset($precos[$item])) {
            $total += $precos[$item];
        }
    }

    return $total;
}

// Função para obter o preço do item
function calcularPreco($item) {
    $precos = [
        'Pizza' => 35.00,
        'Hambúrguer Clássico' => 28.00,
        'Salada' => 22.00,
        'Fritas' => 40.00,
        'Sorvete Artesanal' => 12.00
    ];

    return $precos[$item] ?? 0; // Retorna 0 caso o item não tenha preço registrado
}
?>
