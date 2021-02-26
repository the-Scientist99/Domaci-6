<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "GET")
    redirect("./grad_crud.php?msg=del_err");

isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

if (izbrisati("grad", $id, 'id'))
    redirect("./grad_crud.php?msg=del_suc");
else
    redirect("./grad_crud.php?msg=del_err");
