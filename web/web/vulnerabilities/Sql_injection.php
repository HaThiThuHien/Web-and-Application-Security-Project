<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Injection</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_sql.css"> 
    <style type="text/css">
        #tab {
            background: #2f3640;
            margin-top: 150px;
            width: 1000px;
            color: white;
        }
    </style>
</head>
<body>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    ?>
    <div class="searchBox">
        <form action="#" method="POST">
            <input class="searchInput" type="text" name="content_search" placeholder="Search">
            <button class="searchButton" type="submit" name="submit" value="submit">
                <i class="material-icons">
                    search
                </i>
            </button>
        </form>
        <?php
            if (isset($_POST["submit"])) {
                $search = $_POST["content_search"];

                // Establish a database connection
                $dbh = mysqli_connect('localhost', 'root', 'hahien', 'sqlinjection');

                // Check the database connection
                if (!$dbh) {
                    die("Lỗi kết nối đến cơ sở dữ liệu: " . mysqli_connect_error());
                } else {
                    echo "Kết nối đến cơ sở dữ liệu thành công!<br>";
                }

                // SQL statement vulnerable to SQL Injection
                $sql_stmt = 'SELECT * FROM book WHERE BOOK = "' . $search . '"';

                // Execute the query
                $result = mysqli_query($dbh, $sql_stmt);

                // Check the result
                if ($result) {
                    $rows = mysqli_num_rows($result);
                    if ($rows > 0) {
                        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        
                        // Display the results
                        echo '<table border="1" width="100%" id="tab">
                                <thead>
                                    <th>ID</th>
                                    <th>BOOK</th>
                                    <th>AUTHOR</th>
                                    <th>DESCRIPTION</th>
                                </thead>
                                <tbody>';
                        
                        foreach ($row as $book) {
                            echo '<tr>
                                    <td>' . htmlspecialchars($book['ID']) . '</td>
                                    <td>' . htmlspecialchars($book['BOOK']) . '</td>
                                    <sig0>' . htmlspecialchars($book['AUTHOR']) . '</td>
                                    <td>' . htmlspecialchars($book['DESCRIPTION']) . '</td>
                                  </tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo "Không tìm thấy kết quả phù hợp!";
                    }
                } else {
                    echo "Lỗi truy vấn: " . mysqli_error($dbh);
                }

                // Close the connection
                mysqli_close($dbh);
            }
        ?>

        <p>Harry Potter Series</p>
        <p>The Da Vinci Code</p>
        <p>The Little Prince</p>
        <p>The Lord of the Rings</p>
        <p>Animal Farm</p>
    </div>
</body>
</html>

// ----------------------------------------------------------------------------------------
/*
<?php
    if (!empty($_POST["submit"])) {
        $search = $_POST["content_search"];
        
        // Kết nối đến cơ sở dữ liệu
        $dbh = new mysqli('localhost', 'root', 'hahien', 'sqlinjection');
        
        // Kiểm tra kết nối
        if ($dbh->connect_error) {
            die("Lỗi kết nối: " . $dbh->connect_error);
        }
        
        // Câu lệnh SQL sử dụng Prepared Statements
        $stmt = $dbh->prepare('SELECT * FROM book WHERE BOOK = ?');
        $stmt->bind_param('s', $search);
        
        // Thực thi truy vấn
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Hiển thị kết quả
        if ($result) {
            echo '<table border="1" width="100%" id="tab">
                    <thead>
                        <th>ID</th>
                        <th>BOOK</th>
                        <th>AUTHOR</th>
                        <th>DESCRIPTION</th>
                    </thead>
                    <tbody>';
                    
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['ID']) . '</td>
                        <td>' . htmlspecialchars($row['BOOK']) . '</td>
                        <td>' . htmlspecialchars($row['AUTHOR']) . '</td>
                        <td>' . htmlspecialchars($row['DESCRIPTION']) . '</td>
                      </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo "Lỗi truy vấn: " . $dbh->error;
        }
        
        // Đóng kết nối
        $stmt->close();
        $dbh->close();
    }
?> 
*/
