<?php
include "../db.php";
include "../functions.php";
$res = vratiti('tip_nekretnine');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style.css" />
    <title>Tip Nekretnina CRUD</title>
</head>

<body>
    <div class="container">
        <?php
        $dubina = 1;
        $active = "tip_nekretnine";
        include "./nav.html";
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == "add_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Tip nekretnine uspješno dodan!</h4> </div>";
            if (($_GET['msg'] == "add_err"))
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Tip nekretnine neuspješno dodan!</h4> </div>";
            if ($_GET['msg'] == "del_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Tip nekretnine uspješno izbrisan!</h4> </div>";
            if (($_GET['msg'] == "del_err"))
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Tip nekretnine neuspješno izbrisan!</h4> </div>";
            if ($_GET['msg'] == "e_suc")
                echo " <div class='alert alert-success mt-1 text-center' role='alert'> <h4>Tip nekretnine uspješno izmijenjen!</h4> </div>";
            if (($_GET['msg'] == "e_err"))
                echo " <div class='alert alert-danger mt-1 text-center' role='alert'> <h4>Tip nekretnine neuspješno izmijenjen!</h4> </div>";
        }
        ?>
        <h2 class="text-center mt-3"> SPISAK TABELA NEKRETNINA </h2>
        <div class="row mb-3 mt-1">
            <div class="col-4"></div>
            <button type="button" class="btn btn-success col-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                <i class="fas fa-plus"></i> DODAJ NOVI TIP
            </button>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($res); $i++) {
                        $tip_n = $res[$i];
                        $id = $tip_n['id'];
                        echo "<tr>";
                        echo "  <td> $id </td>";
                        echo "  <td>" . ucwords($tip_n['naziv']) . "</td>";
                        echo "  <td> 
                                    <a class='btn btn-primary' href='./izmijeni_tip_n.php?id=$id'>
                                        <i class='far fa-edit'></i>
                                    </a>
                                </td>";
                        echo "  <td>
                                    <a class='btn btn-danger' onclick='brisi($id)'>
                                        <i class='far fa-trash-alt'></i>
                                    </a>
                                </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Dodaj Novi Tip Nekretnine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./dodaj_tip_n.php" class="form" method="GET">
                            <input type="text" name="naziv" class="form-control" placeholder="Naziv tipa nekretnine ...">
                            <button class="btn btn-success w-100 mt-2">Dodaj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script>
            const brisi = (id) => {
                if (confirm("Da li stvarno želite da izbrišete?"))
                    location.href = "./izbrisi_tip_n.php?id=" + id;
            }
        </script>
</body>

</html>