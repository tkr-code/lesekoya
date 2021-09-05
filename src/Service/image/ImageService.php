<?php
namespace App\Service\Image;

use App\Entity\Image;
use App\Entity\Produit;

class ImageService{
    public function imageProduit(Produit $produit, array $images){
          foreach($images as $image)
            {
                //om gener un nouveau nom de fichier
                $fichier = md5(uniqid()). '.'.$image->guessExtension();

                //on copie le fichier dans le dosiier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                //on stocke l'image dans la base de donnees 
                $img = new Image();
                $img->setName($fichier);
                $produit->addImage($img);
            }
    }
}