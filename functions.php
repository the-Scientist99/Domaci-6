<?php
$dbconn = mysqli_connect("localhost", "root", "", "nekretnina_db");

function redirect($url)
{
    header("location: " . $url);
}

function vratiti($table_name)
{
    global $dbconn;
    $arr = [];
    $q = "SELECT * FROM $table_name";
    $res = mysqli_query($dbconn, $q);

    while ($row = mysqli_fetch_assoc($res)) {
        $arr[] = $row;
    }

    return $arr;
}

function izbrisati($table_name, $id, $id_name)
{
    global $dbconn;
    $res = mysqli_query($dbconn, "DELETE FROM $table_name WHERE $id_name = $id");
    return $res;
}

function dodati($table_name, $arr)
{
    global $dbconn;
    $q_k = [];
    $q_v = [];
    foreach ($arr as $key => $val) {
        $q_k[] = $key;
        $q_v[] = "'" . $val . "'";
    }
    $q = "INSERT INTO $table_name (" . implode(", ", $q_k) . ") VALUES (" . implode(", ", $q_v) . ")";
    if (mysqli_query($dbconn, $q))
        return true;
    else
        return false;
}

function izmijeni($table_name, $arr, $id)
{
    global $dbconn;
    $q_k = [];
    $q_v = [];
    foreach ($arr as $key => $val) {
        $q_kv[] = $key . "='" . $val . "'";
    }
    $q = "UPDATE $table_name SET " . implode(", ", $q_kv) . " WHERE id = $id";
    if (mysqli_query($dbconn, $q))
        return true;
    else
        return false;
}

function selectOptionsGET($arr, $name)
{
    for ($i = 0; $i < count($arr); $i++) {
        $element = $arr[$i];
        $id = $element['id'];
        $sel = "";
        if (isset($_GET[$name]))
            if ($_GET[$name] == $id)
                $sel = "selected";
        echo "<option value='$id' $sel>" . ucfirst($element['naziv']) . "</option>";
    }
}

function selectOptions($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        $element = $arr[$i];
        $id = $element['id'];
        echo "<option value='$id'>" . ucfirst($element['naziv']) . "</option>";
    }
}

function selectOptionsEdit($arr, $name, $nekretnina)
{
    for ($i = 0; $i < count($arr); $i++) {
        $element = $arr[$i];
        $id = $element['id'];
        $sel = "";
        if ($id == $nekretnina[$name])
            $sel = "selected";
        echo "<option value='$id' $sel>" . ucfirst($element['naziv']) . "</option>";
    }
}

function validacijaPretrage($arr, $arr_names)
{
    $arr = [" WHERE 1=1 "];
    for ($i = 0; $i < count($arr_names); $i++) {
        $name = $arr_names[$i];
        if (isset($_GET[$name]) && $_GET[$name] >= "0") {
            $val = $_GET[$name];
            switch ($name) {
                case "grad":
                    $arr[] = " n.grad_id = $val ";
                    break;
                case "tip_n":
                    $arr[] = " n.tip_nekretnine_id = $val ";
                    break;
                case "tip_o":
                    $arr[] = " n.tip_oglasa_id = $val ";
                    break;
                case "min_povrsina":
                    $arr[] = " n.povrsina >= $val ";
                    break;
                case "max_povrsina":
                    $arr[] = " n.povrsina <= $val ";
                    break;
                case "min_cijena":
                    $arr[] = " n.cijena >= $val ";
                    break;
                case "max_cijena":
                    $arr[] = " n.cijena <= $val ";
                    break;
                default:
                    break;
            }
        }
    }
    return $arr;
}

function validacija($key, $type)
{
    if ($type == "GET") {
        if (isset($_GET[$key]) && $_GET[$key] >= "0") return $_GET[$key];
        else return "";
    } else {
        if (isset($_POST[$key]) && $_POST[$key] >= "0") return $_GET[$key];
        else return "";
    }
}
