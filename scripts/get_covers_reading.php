<?php
## tries to grab full and medium size book cover images from the internet archive for all books in /_data/reading.csv

$csvFile = file("../_data/reading.csv");
$data = [];
echo "parsing csv\n";
foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);
}

echo "getting the images\n";
for ($i=1;$i<sizeOf($data);$i++){  #start with 1 to skip header row
  $isbn13 = $data[$i][5];
  $url = "http://covers.openlibrary.org/b/isbn/" . $isbn13 . ".jpg";
  $file = $isbn13  . ".jpg";
  $result = getImage($url,$file);
  $url = "http://covers.openlibrary.org/b/isbn/" . $isbn13 . "-M.jpg";
  $file = $isbn13  . "-M.jpg";
  getImage($url,$file);
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
