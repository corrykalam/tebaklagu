<?php
/*
 * corrykalam
 * 3 juli 2019
 * Recode doesn't make you a Coder
*/
function token(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&refresh_token=refresh_token");
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = array();
    $headers[] = 'Authorization: Basic Zjk2YWFlMTAyZTNhNDU4MDkyYTQyZDY3ZmNmNjMwODM6ZDVmMjNhNTM3OTJkNGNlMTg3YjA5NjE0MTcyYmMzYTc=';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    $tokenz = json_decode($result);
    return $tokenz->access_token;
}

function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}

function search($lagu, $token){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='.$lagu.'&type=album%2Cartist%2Cplaylist%2Ctrack%2Cshow_audio%2Cepisode_audio&market=ID&limit=50');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer '.$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);$xx=curl_close ($ch);
    return $result;
}

function url($url, $token){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer '.$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);$xx=curl_close ($ch);
    $datas = json_decode($result);
    return $datas->preview_url;
}


function urlV1($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, str_replace("https://api.spotify.com/v1/tracks/", "https://open.spotify.com/track/", $url));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    $mp = getStr($result, '<meta property="og:audio" content="','">');
    return $mp;
}