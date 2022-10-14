<?php 
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ArticleFiltre{        
    /**
     * @Assert\Range(
     * min="100"
     * )
     */
    private $maxPrice;

        /**
     * @Assert\Range(
     * min="100"
     * )
     */
    private $minPrice;

    /**
     * Get the value of maxPrice
     * 
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     * @return  self
     */ 
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get min="100",
     */ 
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set min="100",
     *
     * @return  self
     */ 
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }
}