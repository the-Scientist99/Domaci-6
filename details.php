<?php
include "./db.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['id']) ? $id = $_GET['id'] : exit("Error!");

$q = "SELECT n.id, n.povrsina, n.cijena, n.opis, n.god_izgradnje, n.status, n.dat_prodaje, g.naziv AS grad, tn.naziv AS tip_n, tog.naziv AS tip_o
                        FROM nekretnina n 
                        LEFT JOIN grad g ON g.id = n.grad_id
                        LEFT JOIN tip_nekretnine tn ON tn.id = n.tip_nekretnine_id
                        LEFT JOIN tip_oglasa tog ON tog.id = n.tip_oglasa_id
                        WHERE n.id = $id";

$res = mysqli_query($dbconn, $q);
$nekretnina = mysqli_fetch_assoc($res);

$res = mysqli_query($dbconn, "SELECT fotografija FROM foto_nekretnine WHERE nekretnina_id = $id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css" type="text/css">
    <title>Detalji</title>
</head>

<body>
    <div class="container">
        <?php
        include "./nav.html";
        ?>
        <h1 class="text-center alert alert-light border-bottom">DETALJI O NEKRETNINI</h1>
        <div class="row mt-2">
            <div id="carouselExampleControls" class="carousel slide col-8 w-fluid" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $i = 0;
                    while ($fotografija = mysqli_fetch_assoc($res)) {
                        $path = $fotografija['fotografija'];
                        $act = "";
                        if ($i == 0)
                            $act = "active";
                        echo "<div class='carousel-item $act'>";
                        echo "  <img src='$path' class='d-block' alt='fotografija' width='100%' height='500px'>";
                        echo "</div>";
                        $i += 1;
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="col-4">
                <table class="table">
                    <tr>
                        <td>Vrsta nekretnine:</td>
                        <td> <?= ucfirst($nekretnina['tip_n']) ?> </td>
                    </tr>
                    <tr>
                        <td>Tip ponude:</td>
                        <td> <?= ucfirst($nekretnina['tip_o']) ?> </td>
                    </tr>
                    <tr>
                        <td>Grad:</td>
                        <td> <?= ucfirst($nekretnina['grad']) ?> </td>
                    </tr>
                    <tr>
                        <td>Površina:</td>
                        <td> <?= number_format($nekretnina['povrsina']) ?> m <sup>2</sup></td>
                    </tr>
                    <tr>
                        <td>Cijena:</td>
                        <td> <?= number_format($nekretnina['cijena']) ?> &euro; </td>
                    </tr>
                    <tr>
                        <td>Godina izgradnje:</td>
                        <td> <?= $nekretnina['god_izgradnje'] ?> </td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td> <?= ucfirst($nekretnina['status']) ?> </td>
                    </tr>
                    <tr>
                        <td>Datum prodaje:</td>
                        <td>
                            <?php
                            if ($nekretnina['status'] == "dostupno")
                                echo "-------------";
                            else
                                echo $nekretnina['dat_prodaje']
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Opis:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <?php
                            if ($nekretnina['opis'] == NULL) {
                                echo "Nema opisa.";
                            } else {
                                echo $nekretnina['opis'];
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>