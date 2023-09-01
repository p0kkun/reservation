<?php require 'header.php'; ?>
<title>ログイン</title>
</head>
<body>
    <h2>ログイン</h2>
    <form method="POST" action="">
        <label>ユーザー名: </label>
        <input type="text" name="username" required>
        <br>
        <label>パスワード: </label>
        <input type="password" name="pass" required>
        <br>
        <input type="submit" name="login" value="ログイン">
    </form>
    <?php
    if (isset($_POST['login'])) {
        $Username = $_POST['username'];
        $Pass = $_POST['pass'];
        $pdo = new PDO('mysql:host=localhost;dbname=practice;charset=utf8','root','mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM user WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $Username);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result && password_verify($Pass, $result['pass'])) {
            // パスワードが一致した場合
            echo "ログイン成功！";
        } else {
            // ユーザー名またはパスワードが間違っている場合
            echo "ユーザー名またはパスワードが間違っています。";
        }
    }
    ?>
<?php require 'footer.php'; ?>