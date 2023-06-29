<?php

namespace modelo;

use PDOException;

include_once "conexion.php";

class Compras
{
    private $id;
    private $codigoCom;
    private $estado;

    private $idCom;
    private $idPo;
    private $cantidadPoCom;
    private $estadoP;
    public $conexion;

    function __construct()
    {
        $this->conexion = new \Conexion();
    }

    function agregarCompraPokemon()
    {
        try {
            // Asignar valores predeterminados
            $this->estado = 'A';

            $sql = $this->conexion->getCon()->prepare("INSERT INTO compra(codigoCom, estado) VALUES (?, ?)");
            $sql->bindParam(1, $this->codigoCom);
            $sql->bindParam(2, $this->estado);
            $sql->execute();

            return "Pokemon comprado correctamente";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    function agregarDetalleCompra()
    {
        try {
            // Asignar valores predeterminados
            $this->estadoP = 'A';

            $sql = $this->conexion->getCon()->prepare("INSERT INTO comprod(idCom, idPo, cantidadPoCom, estado) VALUES (?, ?, ?, ?)");
            $sql->bindParam(1, $this->idCom);
            $sql->bindParam(2, $this->idPo);
            $sql->bindParam(3, $this->cantidadPoCom);
            $sql->bindParam(4, $this->estadoP);
            $sql->execute();

            return "Detalle de compra agregado correctamente";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    function actualizarCantidadPokemones()
{
    try {
        $sql = $this->conexion->getCon()->prepare("UPDATE pokemones SET cantidadPo = cantidadPo + (SELECT SUM(cantidadPoCom) FROM comprod WHERE idPo = ? AND idCom = (SELECT MAX(idCom) FROM comprod)) WHERE id = ?");
        $sql->bindParam(1, $this->idPo);
        $sql->bindParam(2, $this->idPo);
        $sql->execute();
    } catch (PDOException $e) {
        return "Error al actualizar la cantidad de pokemones: " . $e->getMessage();
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
     * Get the value of codigoCom
     */
    public function getCodigoCom()
    {
        return $this->codigoCom;
    }

    /**
     * Set the value of codigoCom
     *
     * @return  self
     */
    public function setCodigoCom($codigoCom)
    {
        $this->codigoCom = $codigoCom;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of idCom
     */
    public function getIdCom()
    {
        return $this->idCom;
    }

    /**
     * Set the value of idCom
     *
     * @return  self
     */
    public function setIdCom($idCom)
    {
        $this->idCom = $idCom;

        return $this;
    }

    /**
     * Get the value of idPo
     */
    public function getIdPo()
    {
        return $this->idPo;
    }

    /**
     * Set the value of idPo
     *
     * @return  self
     */
    public function setIdPo($idPo)
    {
        $this->idPo = $idPo;

        return $this;
    }

    /**
     * Get the value of cantidadPoCom
     */
    public function getCantidadPoCom()
    {
        return $this->cantidadPoCom;
    }

    /**
     * Set the value of cantidadPoCom
     *
     * @return  self
     */
    public function setCantidadPoCom($cantidadPoCom)
    {
        $this->cantidadPoCom = $cantidadPoCom;

        return $this;
    }

    /**
     * Get the value of estadoP
     */
    public function getEstadoP()
    {
        return $this->estadoP;
    }

    /**
     * Set the value of estadoP
     *
     * @return  self
     */
    public function setEstadoP($estadoP)
    {
        $this->estadoP = $estadoP;

        return $this;
    }
}
