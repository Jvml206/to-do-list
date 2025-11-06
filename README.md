# 📚 Projeto To-do-list
Criadores:

- **Isabela da Silva Santos** - Responsável por: Requisitos não funcionais
- **João Paulo Sá Ribas Santos** - Responsável por: Criar os códigos
- **João Victor Machado Lopes** - Responsável por: Banco de dados
- **Kamilla Gonçalves Kempim** - Responsável por: Requisitos funcionais
- **Verediane Mazutti Filomeno** - Responsável por: CSS 

---

## 🛠️ Tecnologias Utilizadas
- PHP  
- MySQL  
- HTML, CSS, Bootstrap

---

## 🗃️ Estrutura do Projeto
```
/classes
  CRUD.class.php
  Database.class.php
  Lista.class.php
  usuario.class.php
/CSS
  base.css
  login.css
/Script_BD
  grupo.sql
/Documentos
  Diagrama_de_Caso_de_Uso.png
  Diagrama_MER.png
  Requisitos Funcionais.pdf
  Requisitos Não Funcionais.pdf
/img
/script_BD
  bd.sql
.gitignore
alterarSenha.php
cadLista.php
config.ini
dbLista.php
dbUsuario.php
index.php
login.php
logout.php
README.md
validaLogin.php
validaUser.php
      
```

---

## 🗄️ Banco de Dados
Nome do banco: **To_do_list**

Tabelas principais:
- lista
- usuario

---

## 🚀 Como Executar o Projeto
1. Clone este repositório  
2. Importe o arquivo SQL no MySQL  
3. Configure `config.ini`  
    ```
    ['database']
    
    driver      = mysql
    host        = localhost
    port        = 3308
    dbname      = To_do_list
    username    = 
    password    = ""
    ```
4. Acesse no navegador: `http://localhost/To_do_list`

---
