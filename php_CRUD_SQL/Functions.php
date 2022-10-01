<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prodotto";

$connection = new mysqli($servername, $username, $password, $database); //create connection

$Mode = $_GET['Mode'];
if ($Mode == 'Create') {

    $Name = "";
    $Production_Date = "";
    $Expiration_date = "";
    $Category = "";
    $Price = "";

    $success_msg = "";
    $error_msg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $Name = $_POST['Name'];
        $Production_Date = $_POST['Production_Date'];
        $Expiration_date = $_POST['Expiration_date'];
        $Category = $_POST['Category'];
        $Price = $_POST['Price'];

        do {
            if (empty($Name) || empty($Production_Date) || empty($Category) || empty($Price)) {
                $error_msg = "Fields Required";
                break;
            }

            $sql = "INSERT INTO prodotto (Name, Production_Date, Expiration_date, Category, Price) " .
                "Values ('$Name', '$Production_Date', '$Expiration_date', '$Category', '$Price')";
            $result = $connection->query($sql);

            if (!$result) {
                $error_msg = "Invalid query: " . $connection->error;
                break;
            }

            $Name = "";
            $Production_Date = "";
            $Expiration_date = "";
            $Category = "";
            $Price = "";

            $success_msg = "$Name added";
            header("location: /PHP_CRUD_SQL/main.php");
            exit;
        } while (false);
    }
}

if ($Mode == "Edit") {
    $ID = "";
    $Name = "";
    $Production_Date = "";
    $Expiration_date = "";
    $Category = "";
    $Price = "";

    $success_msg = "";
    $error_msg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!isset($_GET["ID"])) {
            header("location: /PHP_CRUD_SQL/main.php");
            exit;
        }
        $ID = $_GET["ID"];
        $sql = "SELECT * FROM prodotto WHERE ID=$ID";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        if (!$row) {
            header("location: /PHP_CRUD_SQL/main.php");
            exit;
        }

        $Name = $row["Name"];
        $Production_Date = $row["Production_Date"];
        $Expiration_date = $row["Expiration_date"];
        $Category = $row["Category"];
        $Price = $row["Price"];
    } else {
        $ID = $_POST["ID"];
        $Name = $_POST["Name"];
        $Production_Date = $_POST["Production_Date"];
        $Expiration_date = $_POST['Expiration_date'];
        $Category = $_POST["Category"];
        $Price = $_POST["Price"];

        do {
            if (empty($Name) || empty($Production_Date) || empty($Category) || empty($Price)) {
                $error_msg = "Fields Required";
                break;
            }

            $sql = "UPDATE prodotto SET Name = '$Name', Production_Date = '$Production_Date', Expiration_date = '$Expiration_date', Category = '$Category', Price = '$Price' WHERE ID = $ID";
            $result = $connection->query($sql);

            if (!$result) {
                $error_msg = "Invalid query: " . $connection->error;
                break;
            }

            $Name = "";
            $Production_Date = "";
            $Expiration_date = "";
            $Category = "";
            $Price = "";

            $success_msg = "$Name updated!";
            header("location: /PHP_CRUD_SQL/main.php");
            exit;
        } while (false);
    }
}
if ($Mode == "Delete") {
    if (isset($_GET['ID'])) {
        $ID = $_GET['ID'];

        $sql = "DELETE FROM prodotto WHERE ID=$ID";
        $connection->query($sql);
    }
    header("location: /PHP_CRUD_SQL/main.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    if ($Mode == 'Create') {
        echo "
    <div class='container my-5'>
        <h2>New Prodotto</h2> ";


        if (!empty($error_msg)) {
            echo "
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>$error_msg</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        ";
        }

        if (!empty($success_msg)) {
            echo "
                            <div class='row mb-3'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$success_msg</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                        ";
        }
        echo "
    </div>

    <form method='post'>
        <label class='col-sm3 col-form-label'>Name</label>
        <div class='col-sm-6'>
            <input type='text' class='form-control' name='Name' value=";
        echo $Name;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Production Date</label>
        <div class='col-sm-6'>
            <input type='date' name='Production_Date' value=";
        echo $Production_Date;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Expiration Date</label>
        <div class='col-sm-6'>
            <input type='date' name='Expiration_Date' value=";
        echo $Expiration_date;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Category</label>
        <div class='col-sm-6'>
            <input type='text' class='form-control' name='Category' value=";
        echo $Category;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Price</label>
        <div class='col-sm-6'>
            <input type='number' class='form-control' name='Price' min='0' step='.01' value=";
        echo $Price;
        echo ">
        </div>
        <div class='row mb-3'>
            <div class='offset-sm-3 col-sm-3 d-grid'>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </div>
            <div class='col-sm-3 d-grid'>
                <a class='btn btn-outline-primary' href='/PHP_CRUD_SQL/main.php' role='button'>Cancel</a>
            </div>
    </form>
    ";
    }



    if ($Mode == "Edit") {
        echo "
    <div class='container my-5'>
        <h2>New Prodotto</h2> ";


        if (!empty($error_msg)) {
            echo "
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>$error_msg</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        ";
        }

        if (!empty($success_msg)) {
            echo "
                            <div class='row mb-3'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$success_msg</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                        ";
        }
        echo "
    </div>

    <form method='post'>
        <input type='hidden' name='ID' value=";
        echo $ID;
        echo ">
        <label class='col-sm3 col-form-label'>Name</label>
        <div class='col-sm-6'>
            <input type='text' class='form-control' name='Name' value=";
        echo $Name;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Production Date</label>
        <div class='col-sm-6'>
            <input type='date' name='Production_Date' value=";
        echo $Production_Date;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Expiration Date</label>
        <div class='col-sm-6'>
            <input type='date' name='Expiration_Date' value=";
        echo $Expiration_date;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Category</label>
        <div class='col-sm-6'>
            <input type='text' class='form-control' name='Category' value=";
        echo $Category;
        echo ">
        </div>
        <label class='col-sm3 col-form-label'>Price</label>
        <div class='col-sm-6'>
            <input type='number' class='form-control' name='Price' min='0' step='.01' value=";
        echo $Price;
        echo ">
        </div>
        <div class='row mb-3'>
            <div class='offset-sm-3 col-sm-3 d-grid'>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </div>
            <div class='col-sm-3 d-grid'>
                <a class='btn btn-outline-primary' href='/PHP_CRUD_SQL/main.php' role='button'>Cancel</a>
            </div>
    </form>
    ";
    }
    ?>
</body>
</html>