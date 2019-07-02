<?php
/*
 * corrykalam
 * 3 juli 2019
 * Recode doesn't make you a Coder
*/
require 'function.php';
$conn = mysqli_connect("localhost", "USERNAME", "PASSWORD", "NAMADB");

$search = $_GET["search"];
$searchv1 = str_replace(" ", "+", $search);
$token = token();
$search = search($searchv1, $token);
$datas = json_decode($search);
$artis = $datas->tracks->items[0]->album->artists[0]->name;
if($artis != null){
    $urls = $datas->tracks->items[0]->href;
    $judul = $datas->tracks->items[0]->name;
    $urlsong = url($urls, $token);
    if($urlsong == null){
        $geturlv1 = urlV1($urls);
        $query = "INSERT INTO data (id, judul, artis, url, uspotify) VALUES ('', '$judul', '$artis', '$geturlv1', '$urls')";
        mysqli_query($conn, $query);
        if( mysqli_affected_rows($conn) > 0 ) {
            $datas = json_encode([
                'status' => true,
                'judul' => $judul,
                'artis' => $artis,
                'url' => $geturlv1
            ]);
            echo $datas;
        }else{
            $datas = json_encode([
                'status' => false,
                'alasan' => 'lagu sudah ada :)' 
            ]);
            echo $datas;
        }    
    }else{
        $query = "INSERT INTO data (id, judul, artis, url, uspotify) VALUES ('', '$judul', '$artis', '$urlsong', '$urls')";
        mysqli_query($conn, $query);
        if( mysqli_affected_rows($conn) > 0 ) {
            $datas = json_encode([
                'status' => true,
                'judul' => $judul,
                'artis' => $artis,
                'url' => $urlsong
            ]);
            echo $datas;
        }else{
            $datas = json_encode([
                'status' => false,
                'alasan' => 'lagu sudah ada :)' 
            ]);
            echo $datas;
        } 
    }
}else{
    $datas = json_encode([
        'status' => false,
        'alasan' => 'lagu tidak ditemukan' 
    ]);
    echo $datas;
}