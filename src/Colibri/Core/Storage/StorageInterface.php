<?php

namespace Colibri\Core\Storage;

/**
 * Interface StorageInterface
 * @package Colibri
 */
interface StorageInterface {

  /**
   * @param array $data
   * @return mixed
   */
  public function persist(array $data = []);

  /**
   * @param $id
   * @return mixed
   */
  public function retrieve($id);

  /**
   * @param $id
   * @return mixed
   */
  public function remove($id);

}