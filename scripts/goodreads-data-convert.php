<?php

##import csv;

$sourceFile = file("../_data/goodreads.csv");
$targetFile = fopen("../_data/reading-combined.csv","a");
$data = [];


foreach ($sourceFile as $line) {
    $data[] = str_getcsv($line);
}
array_splice($data, 0, 1);
foreach ($data as $line) {
  $record = array(
    'Title' => $line[1],
    'Authors' => $line[3],
    'ISBN13'  => $line[6],
    'MyRating' => $line[7],
    'Publisher' => $line[9],
    'DateRead' => $line[15],
    'externalLink' => ""
  );
  if($line[14] != ""){
    $record['DateRead'] = $line[14];
  }
  fputcsv($targetFile, $record); # $record is an array of strings (array|string[])

}


##echo $data[1][0];
## convert $data[] to correctly formatted array
## write line by line to $targetFile

fclose($targetFile);

?>
