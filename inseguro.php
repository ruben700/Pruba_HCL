<?php
// 🚨 Hardcoded Credentials (Alta)
$db_user = "admin";
$db_pass = "123456"; // No usar credenciales fijas en producción

// 🚨 Conexión insegura con MySQL sin usar prepared statements (SQL Injection - Crítica)
$conn = mysqli_connect("localhost", $db_user, $db_pass, "testdb");
$user_input = $_GET['id'];
$query = "SELECT * FROM users WHERE id = '$user_input'";
$result = mysqli_query($conn, $query);

// Mostrar resultados
while ($row = mysqli_fetch_assoc($result)) {
    echo "Usuario: " . htmlspecialchars($row['username']) . "<br>";
}

// 🚨 XSS (Alta): input reflejado sin sanitizar
$search = $_GET['search'];
echo "Resultados para: $search"; // No se usa htmlspecialchars()

// 🚨 RCE - Remote Code Execution (Crítica)
$cmd = $_GET['cmd'];
eval($cmd); // No usar eval con input del usuario

// 🚨 File Upload inseguro (Alta)
if(isset($_FILES['archivo'])) {
    move_uploaded_file($_FILES['archivo']['tmp_name'], "uploads/" . $_FILES['archivo']['name']);
    echo "Archivo subido.";
}

// 🚨 Directory Traversal (Alta)
$file = $_GET['file'];
$content = file_get_contents("docs/" . $file);
echo $content;
?>
