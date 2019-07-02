<?php
/*
 * corrykalam
 * 3 juli 2019
 * Recode doesn't make you a Coder
*/
$conn = mysqli_connect("localhost", "USERNAME", "PASSWORD", "NAMADB");

$result = mysqli_query($conn,"SELECT * FROM data order by RAND() limit 1");
$var = mysqli_fetch_row($result);
$datas = json_encode([
    'judul' => $var[1],
    'artis' => $var[2],
    'url' => $var[3]
    ]);
echo $datas;