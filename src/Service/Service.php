<?php 
namespace App\Service;
class Service{
    public function aleatoire(int $int)
    {
      $string ="";
      $chaine ="abcdefghijklmnopqrstuvwxyz0123456789";
      srand((double)microtime()*1000000);
      for($i=0; $i< $int;$i++)
      {
        $string.=$chaine[rand()%strlen($chaine)];
      }
      return $string;
    }
    public function coupon(int $int = 8)
    {
      $string ="";
      $chaine ="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      srand((double)microtime()*1000000);
      for($i=0; $i< $int;$i++)
      {
        $string.=$chaine[rand()%strlen($chaine)];
      }
     return substr_replace($string,'-',4).substr($string,4);
    }
}