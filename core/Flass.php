<?php
class Flass {
  static public function msg(String $msg): void
  {
    echo "<script>alert('$msg')</script>";  
  }
}