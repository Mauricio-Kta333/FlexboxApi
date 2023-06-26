<?php

namespace modelo;

use Exception;
use PDOException;

include_once "conexion.php";

class Pokemones
{
    private $id;
    private $nombrePo;
    private $precioPo;
    private $cantidadPo;
    private $descripPo;
    private $estado;
    public $conexion;

    function __construct()
    {
        $this->conexion = new \Conexion();
    }

    public function agregarPokemon()
    {
        try {
            // Verificar si el Pokémon ya existe en la base de datos
            $sql = $this->conexion->getCon()->prepare("SELECT id FROM pokemones WHERE nombrePo = ?");
            $sql->bindParam(1, $this->nombrePo);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return "El Pokémon ya existe en la base de datos.";
            }

            // El Pokémon no existe, realizar la inserción
            $sql = $this->conexion->getCon()->prepare("INSERT INTO pokemones(id, nombrePo, precioPo, cantidadPo, descripPo, estado) VALUES (?, ?, ?, ?, ?, 'A')");
            $sql->bindParam(1, $this->id);
            $sql->bindParam(2, $this->nombrePo);
            $sql->bindParam(3, $this->precioPo);
            $sql->bindParam(4, $this->cantidadPo);
            $sql->bindParam(5, $this->descripPo);
            $sql->execute();

            return "Pokémon agregado correctamente.";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    function readPokemones()
    {
        try {
            $sql = $this->conexion->getCon()->prepare("SELECT * FROM pokemones");
            $sql->execute();
            $response = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (PDOException $e) {
            return "Error: ".$e->getMessage();
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombrePo
     */
    public function getNombrePo()
    {
        return $this->nombrePo;
    }

    /**
     * Set the value of nombrePo
     *
     * @return  self
     */
    public function setNombrePo($nombrePo)
    {
        $this->nombrePo = $nombrePo;

        return $this;
    }

    /**
     * Get the value of precioPo
     */
    public function getPrecioPo()
    {
        return $this->precioPo;
    }

    /**
     * Set the value of precioPo
     *
     * @return  self
     */
    public function setPrecioPo($precioPo)
    {
        $this->precioPo = $precioPo;

        return $this;
    }

    /**
     * Get the value of cantidadPo
     */
    public function getCantidadPo()
    {
        return $this->cantidadPo;
    }

    /**
     * Set the value of cantidadPo
     *
     * @return  self
     */
    public function setCantidadPo($cantidadPo)
    {
        $this->cantidadPo = $cantidadPo;

        return $this;
    }

    /**
     * Get the value of descriPo
     */
    public function getDescripPo()
    {
        return $this->descripPo;
    }

    /**
     * Set the value of descriPo
     *
     * @return  self
     */
    public function setDescripPo($descripPo)
    {
        $this->descripPo = $descripPo;

        return $this;
    }

    /**
     * Get the value of descriPo
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of descriPo
     *
     * @return  self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }
}
