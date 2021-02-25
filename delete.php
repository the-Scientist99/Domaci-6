<?php
include "./db.php";
include "./functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['id']) ? $id = $_GET['id'] : redirect("./index.php?msg=del_err");

$q_s = "SELECT fotografija FROM foto_nekretnine WHERE nekretnina_id = $id";

mysqli_query($dbconn, "BEGIN");
$rez_s = mysqli_query($dbconn, $q_s);
if ($rez_s)
    while ($foto = mysqli_fetch_assoc($rez_s))
        unlink($foto['fotografija']);
else
    mysqli_query($dbconn, "ROLLBACK");

$rez_f = izbrisati("foto_nekretnine", $id);
$rez_n = izbrisati("nekretnina", $id);

if ($rez_f && $rez_n) {
    mysqli_query($dbconn, "COMMIT");
    redirect("./index.php?msg=del_suc");
} else
    mysqli_query($dbconn, "ROLLBACK");
