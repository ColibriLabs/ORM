<?php

/**
 * Generated By ColibriORM Generator
 * @author Ivan Gontarenko
*/

namespace ProCard\Models\Base;

use Colibri\Core\Entity;

/**
 * Entity class for representation table 'products'
 */
class BaseProduct extends Entity
{

  const TABLE = 'products';

  const ID = 'products.id';
  const CATEGORY_ID = 'products.category_id';
  const MANUFACTURER_ID = 'products.manufacturer_id';
  const PICTURE_ID = 'products.picture_id';
  const SLUG = 'products.slug';
  const CODE = 'products.vendor_code';
  const NAME = 'products.name';
  const PRICE = 'products.price';
  const HAS_IN_STOCK = 'products.product_in_stock';
  const QUANTITY = 'products.quantity';
  const STATUS = 'products.status';
  const VERSION = 'products.version';
  const MODIFIED = 'products.created';
  const ID_KEY = 'id';
  const CATEGORY_ID_KEY = 'category_id';
  const MANUFACTURER_ID_KEY = 'manufacturer_id';
  const PICTURE_ID_KEY = 'picture_id';
  const SLUG_KEY = 'slug';
  const CODE_KEY = 'vendor_code';
  const NAME_KEY = 'name';
  const PRICE_KEY = 'price';
  const HAS_IN_STOCK_KEY = 'product_in_stock';
  const QUANTITY_KEY = 'quantity';
  const STATUS_KEY = 'status';
  const VERSION_KEY = 'version';
  const MODIFIED_KEY = 'created';
  const ENUM_STATUS_OK = 'OK';
  const ENUM_STATUS_AO = 'AO';
  const ENUM_STATUS_RQ = 'RQ';
  const ENUM_STATUS_XX = 'XX';
  
  /**
   * @var integer
   */
  public $id;
  
  /**
   * @var integer
   */
  public $categoryId;
  
  /**
   * @var integer
   */
  public $manufacturerId;
  
  /**
   * @var integer
   */
  public $pictureId;
  
  /**
   * @var string
   */
  public $slug;
  
  /**
   * @var string
   */
  public $code;
  
  /**
   * @var string
   */
  public $name;
  
  /**
   * @var double
   */
  public $price;
  
  /**
   * @var boolean
   */
  public $hasInStock;
  
  /**
   * @var integer
   */
  public $quantity;
  
  /**
   * @var string
   */
  public $status;
  
  /**
   * @var integer
   */
  public $version;
  
  /**
   * @var string
   */
  public $modified;

  /**
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return integer
   */
  public function getCategoryId()
  {
    return $this->categoryId;
  }

  /**
   * @return integer
   */
  public function getManufacturerId()
  {
    return $this->manufacturerId;
  }

  /**
   * @return integer
   */
  public function getPictureId()
  {
    return $this->pictureId;
  }

  /**
   * @return string
   */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
   * @return string
   */
  public function getCode()
  {
    return $this->code;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return double
   */
  public function getPrice()
  {
    return $this->price;
  }

  /**
   * @return boolean
   */
  public function getHasInStock()
  {
    return $this->hasInStock;
  }

  /**
   * @return integer
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * @return string
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * @return integer
   */
  public function getVersion()
  {
    return $this->version;
  }

  /**
   * @return string
   */
  public function getModified()
  {
    return $this->modified;
  }


  /**
   * @param integer $id
   * @return $this
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * @param integer $categoryId
   * @return $this
   */
  public function setCategoryId($categoryId)
  {
    $this->categoryId = $categoryId;

    return $this;
  }

  /**
   * @param integer $manufacturerId
   * @return $this
   */
  public function setManufacturerId($manufacturerId)
  {
    $this->manufacturerId = $manufacturerId;

    return $this;
  }

  /**
   * @param integer $pictureId
   * @return $this
   */
  public function setPictureId($pictureId)
  {
    $this->pictureId = $pictureId;

    return $this;
  }

  /**
   * @param string $slug
   * @return $this
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;

    return $this;
  }

  /**
   * @param string $code
   * @return $this
   */
  public function setCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * @param string $name
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @param double $price
   * @return $this
   */
  public function setPrice($price)
  {
    $this->price = $price;

    return $this;
  }

  /**
   * @param boolean $hasInStock
   * @return $this
   */
  public function setHasInStock($hasInStock)
  {
    $this->hasInStock = $hasInStock;

    return $this;
  }

  /**
   * @param integer $quantity
   * @return $this
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }

  /**
   * @param string $status
   * @return $this
   */
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * @param integer $version
   * @return $this
   */
  public function setVersion($version)
  {
    $this->version = $version;

    return $this;
  }

  /**
   * @param string $modified
   * @return $this
   */
  public function setModified($modified)
  {
    $this->modified = $modified;

    return $this;
  }

}