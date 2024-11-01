import mariadb

conexao = mariadb.connect(
    user="root",
    password="4ever",
    host="localhost",
    port=3306,
    database="armazenamentosj"
)

sql = conexao.cursor()
comanda = 1
produto = input("novo produto")
preço = input("preço")
try:
    sql.execute("insert into pedidos (produto, preço) values (?,?)", (produto, preço))
    conexao.commit()
except:
    print("error")
conexao.close()