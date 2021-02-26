<?php
include "./db.php";
include "./functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['id']) ? $id = $_GET['id'] : redirect("./index.php?msg=del_err");

$q_s = "SELECT fotografija FROM foto_nekretnine WHERE nekretnina_id = $id";

$rez_s = mysqli_query($dbconn, $q_s);
$rez_f = izbrisati("foto_nekretnine", $id, 'nekretnina_id');
$rez_n = izbrisati("nekretnina", $id, 'id');

mysqli_query($dbconn, "BEGIN");
if ($rez_f) {
    if ($rez_n) {
        while ($foto = mysqli_fetch_assoc($rez_s)) {
            unlink($foto['fotografija']);
        }
        mysqli_query($dbconn, "COMMIT");
        redirect("./index.php?msg=del_suc");
    } else {
        mysqli_query($dbconn, "ROLLBACK");
        redirect("./index.php?msg=del_err");
    }
} else {
    mysqli_query($dbconn, "ROLLBACK");
    redirect("./index.php?msg=del_err");
}
