<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    redirect("./tip_nek_crud.php?msg=del_err");

isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

if (izbrisati("tip_nekretnine", $id, 'id'))
    redirect("./tip_nek_crud.php?msg=del_suc");
else
    redirect("./tip_nek_crud.php?msg=del_err");
