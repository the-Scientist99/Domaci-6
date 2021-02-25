<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    redirect("./tip_nek_crud.php?msg=add_err");

isset($_GET['naziv']) ? $naziv = $_GET['naziv'] : $naziv = "";
$arr_q = ['naziv' => $naziv];

if (dodati('tip_nekretnine', $arr_q))
    redirect("./tip_nek_crud.php?msg=add_suc");
else
    redirect("./tip_nek_crud.php?msg=add_err");
