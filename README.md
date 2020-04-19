# Class PHP Auto TopupFireFree
- ระบบเติมเพชรในเกม FreeFire Auto ผ่าน บัตรการีน่า

# Variable
- $open_id //เลขไอดีในเกม FreeFire
- $garena_card //เลขบัตรการีน่า (ราคาตาม Package ในเว็บ Termgame.com)

# Example
```
<?php
  require "freefire.class.php";
  $ff = new FreeFire();
  $open_id = XXXXXXXXX;
  $garena_card = XXXXXXXXXXXXXXXX;
  
  print_r($ff->Login($open_id));
  print_r($ff->BuyDiamond($garena_card));
?>

# Readme
- Api นี้ไม่ใช้ Official !
- Class ตัวนี้เเจกฟรีไม่ได้ต้องการเงินอย่างใด !
```
