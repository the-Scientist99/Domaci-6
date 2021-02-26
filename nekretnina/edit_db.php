<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "POST")
    exit("Neovlašćen pristup!");

$ind = true;
isset($_POST['id'])                                         ? $id = $_POST['id']                       : $ind = false;
isset($_POST['grad'])     && $_POST['grad'] != "0"          ? $grad = $_POST['grad']                   : $ind = false;
isset($_POST['tip_o'])    && $_POST['tip_o'] != "0"         ? $tip_o = $_POST['tip_o']                 : $ind = false;
isset($_POST['tip_n'])    && $_POST['tip_n'] != "0"         ? $tip_n = $_POST['tip_n']                 : $ind = false;
isset($_POST['povrsina']) && is_numeric($_POST['povrsina']) ? $povrsina = $_POST['povrsina']           : $ind = false;
isset($_POST['cijena'])   && is_numeric($_POST['cijena'])   ? $cijena = $_POST['cijena']               : $ind = false;
isset($_POST['god_izgradnje'])                              ? $god_izgradnje = $_POST['god_izgradnje'] : $ind = false;
isset($_POST['status'])                                     ? $status = $_POST['status']               : $ind = false;
isset($_POST['dat_prodaje'])                                ? $dat_prodaje = $_POST['dat_prodaje']     : $ind = false;
isset($_POST['opis'])                                       ? $opis = $_POST['opis']                   : $ind = false;

if ($dat_prodaje == "") $dat_prodaje = date("Y-m-d");

if (!$ind)
    redirect("../index.php?msg=e_err");

$arr = [
    'grad_id' => $grad,
    'tip_oglasa_id' => $tip_o,
    'tip_nekretnine_id' => $tip_n,
    'povrsina' => $povrsina,
    'cijena' => $cijena,
    'god_izgradnje' => $god_izgradnje,
    'opis' => $opis,
    'status' => $status,
    'dat_prodaje' => $dat_prodaje
];

if (izmijeni('nekretnina', $arr, $id))
    redirect("../index.php?msg=e_suc");
else
    redirect('../index.php?msg=e_err');
