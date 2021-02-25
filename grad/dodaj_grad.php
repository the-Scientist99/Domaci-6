<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    exit("Neovlašćen pristup!");

isset($_GET['naziv']) ? $naziv = $_GET['naziv'] : $naziv = "";
$arr = ['naziv' => $naziv];

if (dodati('grad', $arr))
    redirect("./grad_crud.php?msg=add_suc");
else
    redirect("./grad_crud.php?msg=add_err");
