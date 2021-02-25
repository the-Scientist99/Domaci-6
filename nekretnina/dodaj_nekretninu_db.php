<?php
include "../db.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] != "POST")
    exit("Neovlašćen pristup!");

$ind = true;
isset($_POST['grad'])          && $_POST['grad'] != "0"          ? $grad = $_POST['grad']                   : $ind = false;
isset($_POST['tip_o'])         && $_POST['tip_o'] != "0"         ? $tip_o = $_POST['tip_o']                 : $ind = false;
isset($_POST['tip_n'])         && $_POST['tip_n'] != "0"         ? $tip_n = $_POST['tip_n']                 : $ind = false;
isset($_POST['povrsina'])      && is_numeric($_POST['povrsina']) ? $povrsina = $_POST['povrsina']           : $ind = false;
isset($_POST['cijena'])        && is_numeric($_POST['cijena'])   ? $cijena = $_POST['cijena']               : $ind = false;
isset($_POST['god_izgradnje']) && $_POST['god_izgradnje'] != ""  ? $god_izgradnje = $_POST['god_izgradnje'] : $god_izgradnje = "";
isset($_POST['opis'])                                            ? $opis = $_POST['opis']                   : $opis = "";

if (!$ind)
    redirect("./dodaj_nekretninu.php?msg=add_err");

$arr_n = [
    'grad_id' => $grad,
    'tip_oglasa_id' => $tip_o,
    'tip_nekretnine_id' => $tip_n,
    'povrsina' => $povrsina,
    'cijena' => $cijena,
    'god_izgradnje' => $god_izgradnje,
    'opis' => $opis
];

if (!dodati('nekretnina', $arr_n))
    redirect("./dodaj_nekretninu.php?msg=add_err");

if (isset($_FILES['fotografija'])) {
    $foto = $_FILES['fotografija'];
    $fotoCount = count($foto["name"]);

    for ($i = 0; $i < $fotoCount; $i++) {
        $ext = explode(".", $foto['name'][$i]);
        $ext = $ext[count($ext) - 1];

        $dest = "./uploads/" . uniqid() . "." . $ext;
        $path = "../" . $dest;
        copy($foto['tmp_name'][$i], $path);

        $arr_f = ['fotografija' => $dest, 'nekretnina_id' => $id];
        dodati('foto_nekretnine', $arr_f);
    }
    redirect("./dodaj_nekretninu.php?msg=add_suc");
} else
    redirect("./dodaj_nekretninu.php?msg=add_err");
