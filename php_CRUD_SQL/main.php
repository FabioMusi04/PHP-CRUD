<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container my-5">
        <h2>List of Prodotti</h2>
        <a href="/PHP_CRUD_SQL/Functions.php?Mode=Create" class="btn btn-primary" role="button">New Prodotto</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Production Date</th>
                    <th>Expiration Date</th>
                    <th>Category</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "prodotto";

                $connection = new mysqli($servername, $username, $password, $database); //create connection

                if ($connection->connect_error) { //check connetcion 
                    die("Connection failed: " . $connection->connect_error);
                }

                $sql = "SELECT * FROM Prodotto";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid Query: " . $connection->connect_error);
                }
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[ID]</td>
                        <td>$row[Name]</td>
                        <td>$row[Production_Date]</td>
                        <td>";
                    echo $row['Expiration_date'] == "0000-00-00" ? "Doesn't have one" : $row['Expiration_date'];
                    echo "</td>
                        <td>$row[Category]</td>
                        <td>$row[Price]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/PHP_CRUD_SQL/Functions.php/?Mode=Edit&ID=$row[ID]'>EDIT</a>
                            <a class='btn btn-danger btn-sm' href='javascript: delete_user($row[ID]))'>DELETE</a>
                        </td>
                    </tr>
                    ";
                }

                ?>
            </tbody>
        </table>
    </div>
</body>
<script type="text/javascript">
    function delete_user(uid) {
        if (confirm('Are You Sure to Delete this Record? ')) {
            window.location.href = '/PHP_CRUD_SQL/Functions.php/?Mode=Delete&ID=' + uid;
        }
    }
</script>

</html>