<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    redirect("./grad_crud.php?msg=e_err");

isset($_GET['id']) ? $id = $_GET['id'] : $id = "";
isset($_GET['naziv']) ? $naziv = $_GET['naziv'] : $naziv = "";

$arr = ['naziv' => $naziv];
if (izmijeni('grad', $arr, $id))
    redirect("./grad_crud.php?msg=e_suc");
else
    redirect("./grad_crud.php?msg=e_err");
