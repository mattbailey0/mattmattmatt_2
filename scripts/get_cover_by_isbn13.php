<?php
## tries to grab full and medium size book cover images from the internet archive for all books in /_data/reading.csv

$csvFile = file("../_data/reading.csv");

echo "\n";
if(count($argv) > 1){

  $isbn13 = $argv[1];

  echo "attempting to get covers for " . $isbn13 . "\n";

  $url = "http://covers.openlibrary.org/b/isbn/" . $isbn13 . ".jpg";
  $file = $isbn13  . ".jpg";
  $result = getImage($url,$file);
  $url = "http://covers.openlibrary.org/b/isbn/" . $isbn13 . "-M.jpg";
  $file = $isbn13  . "-M.jpg";
  getImage($url,$file);
} else {
  echo "please specify an ISBN13 as a command line parameter\n";
}

function getImage($url,$file){
  $ch = curl_init($url);
  $fp = fopen($file, "w");
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_exec($ch);
  if(curl_error($ch)) {
      fwrite($fp, curl_error($ch));
  }
  curl_close($ch);
  fclose($fp);
}
?>
