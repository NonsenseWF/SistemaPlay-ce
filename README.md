## Pré-requisitos

- [XAMPP](https://www.apachefriends.org/index.html) instalado em seu computador (XAMPP inclui Apache, PHP e MySQL).
- Editor de código de sua preferência (como VSCode, Sublime Text, etc.).

## Passos para rodar o projeto

### 1. Instalar o XAMPP

- Baixe o XAMPP a partir do site oficial: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
- Siga as instruções de instalação para seu sistema operacional.

### 2. Configurar o XAMPP

1. **Abra o XAMPP**.
2. Inicie os módulos **Apache** e **MySQL** (basta clicar no botão "Start" ao lado de cada um).
3. Verifique se o Apache está rodando corretamente acessando `http://localhost` em seu navegador. Se tudo estiver certo, você verá a página de boas-vindas do XAMPP.

### 3. Configurar o projeto na pasta `htdocs`

1. Localize o diretório onde o XAMPP foi instalado. Geralmente está em:
   - `C:\xampp\` (Windows)
   - `/Applications/XAMPP/htdocs` (Mac)
   - `/opt/lampp/htdocs` (Linux)
2. Copie a pasta do projeto (com o arquivo HTML e a estrutura de arquivos) para a pasta `htdocs`.
3. Renomeie a pasta do projeto se desejar, por exemplo, para `cardapio`.

### 4. Acessar o projeto pelo navegador

1. No navegador, acesse o projeto usando a URL `http://localhost/nome_da_pasta`, onde `nome_da_pasta` é o nome que você deu à pasta do projeto dentro de `htdocs` (por exemplo, `cardapio`).
   - Exemplo: `http://localhost/cardapio`

Se o projeto estiver corretamente configurado, a página do cardápio interativo deverá ser carregada.

---

## Estrutura do Projeto

- **index.html**: Arquivo principal com o HTML e CSS do cardápio interativo.
- **README.md**: Este guia de instruções.

---

## Dicas

- Certifique-se de que o Apache está rodando no XAMPP sempre que você quiser acessar o projeto no navegador.
- Para editar o conteúdo, abra os arquivos HTML no editor de código de sua preferência.

---

Com isso, você configurou e executou o projeto localmente. Divirta-se explorando e personalizando o cardápio!
