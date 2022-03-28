<?php
require_once "../init.php";

$DB = new Database();
$data = [
  'makan' => 'ayam',
  'minum' => 'jus',
  'hewan' => 'kucing'
];

$by = ['key' => 3];
$DB->update('makan', $data, $by);
