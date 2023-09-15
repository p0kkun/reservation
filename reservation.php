<?php
require 'header.php';
?>
<title>ユーザー名とパスワードの入力フォーム</title>
</head>


<body>
    <h2>ユーザー名とパスワードの入力フォーム</h2>
    <form method="POST" action="">
        <label>ユーザー名: </label>
        <input type="text" name="username" required>
        <br>
        <label>パスワード: </label>
        <input type="password" name="pass" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$" title="アルファベットの大文字、小文字、数字を一つ以上含めてください">
        <br>
        <input type="submit" name="submit" value="送信">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['pass'];
        // パスワードをハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $pdo = new PDO('mysql:host=localhost;dbname=practice;charset=utf8', 'root', 'mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $query = "INSERT INTO user (username, pass) VALUES (:username, :pass)";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':username', $username);
            $statement->bindParam(':pass', $hashedPassword); // ハッシュ化したパスワードを格納
            $statement->execute();
            echo "登録が完了しました！3秒後にログイン画面に飛びます";
            header("refresh:3;url=login.php");
        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
        // データベースの接続を閉じる
        $pdo = null;
    }
    ?>
    <?php require 'footer.php'; ?>