# Aula de PHP: Login e Dashboard

Bem-vindo ao repositório da aula de **PHP**, onde desenvolvemos um sistema básico de login e dashboard. Esta aula foi transmitida ao vivo no Twitch, no meu canal.

---

## 🎯 Objetivos da Aula

Durante esta live, aprendemos a:

1. Criar uma **página de login** em HTML e CSS.
2. Construir um **dashboard** com interface simples.
3. Desenvolver o **script de acesso à conta** em PHP.
4. Verificar se o usuário está logado antes de acessar páginas restritas.
5. Implementar a função de **logout** para encerrar a sessão do usuário.
6. Conectar o PHP ao **MariaDB** usando **mysqli procedural** para verificar o acesso de usuários e senhas, além de salvar tokens de acesso.

---

## 💻 Tecnologias Utilizadas

- **PHP** – Linguagem de programação.
- **MariaDB** – Banco de dados relacional.
- **HTML5 e CSS3** – Estrutura e estilização das páginas.
- **Twitch** – Plataforma utilizada para transmissão ao vivo.

---

## 📂 Estrutura do Projeto

```
/miaula-login/
│
├─ index.php          # Página de login
├─ dashboard.php      # Dashboard após login
├─ logout.php         # Script para encerrar sessão
├─ login.php          # Script de verificação de login
├─ config.php         # Conexão com MariaDB
└─ README.md          # Este arquivo
```

---

## ⚡ Funcionalidades

### 1. Login
- Usuário entra com **email/usuário e senha**.
- Gera **tokens de acesso**.
- Script valida os dados no banco MariaDB.
- Se válido, inicia a **sessão do usuário**.

### 2. Dashboard
- Página acessível apenas se o usuário estiver logado.
- Mostra uma interface simples de boas-vindas e opções básicas.

### 3. Logout
- Finaliza a sessão do usuário.
- Redireciona para a página de login.

### 4. Comparação de cookie e registro
- Cada página restrita checa se o cookie e registro está ativo.
- Caso contrário, redireciona o usuário para o login.

---

## 🔧 Como Executar

1. Clone este repositório:
```
git clone https://github.com/mugomes/miaula-login.git
```

2. Configure o MariaDB:
```
CREATE DATABASE miaula1;
USE miaula1;

CREATE TABLE mi_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idtoken1 LONGTEXT NOT NULL,
    idtoken2 LONGTEXT NOT NULL,
    email LONGTEXT NOT NULL,
    senha LONGTEXT NOT NULL
);
```

3. Adicione as suas credenciais no arquivo `config.php`.

4. Abra o projeto em seu navegador via servidor local (LAMP, XAMPP, Laragon ou PHP nativo).

---

## 📺 Link da Live

A aula foi transmitida ao vivo no Twitch. Confira a gravação [aqui](https://www.twitch.tv/profmu).

---

## 📌 Observações

- Este projeto é para fins educacionais.
- Não utilize senhas reais em ambientes de produção sem hash e medidas de segurança adequadas (ex.: `password_hash()` e `password_verify()`).
- O design é simples, mas pode ser aprimorado.

---

## 🙌 Contribuição

Sinta-se à vontade para:
- Estudar o código.
- Modificar estilos e funcionalidades.

---

Feito com 💜 para aprendizado de PHP!