<?php

namespace modelo;

use Error;
use Exception;
use PDOException;

include_once "conexion.php";

class Pedidos
{
    private $id;
    private $codigoPed;
    private $idUsuario;
    private $nombre;
    private $direccion;
    private $telefono;
    private $totalPedido;
    private $formaPago;
    private $estadoPedido;
    private $estado;


    private $idPed;
    private $idPo;
    private $cantidadPoke;
    private $estadoP;
    public $conexion;

    function __construct()
    {
        $this->conexion = new \Conexion();
    }

    function agregarDatosUsuarios()
    {
        try {
            // Asignar valores predeterminados
            $this->formaPago = 'Transferencia';
            $this->estadoPedido = 'Pendiente';
            $this->estado = 'A';

            $sql = $this->conexion->getCon()->prepare("INSERT INTO pedido(codigoPed, idUsu, nombre, direccion, telefono, totalPed, formaPago, estadoPedido, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bindParam(1, $this->codigoPed);
            $sql->bindParam(2, $this->idUsuario);
            $sql->bindParam(3, $this->nombre);
            $sql->bindParam(4, $this->direccion);
            $sql->bindParam(5, $this->telefono);
            $sql->bindParam(6, $this->totalPedido);
            $sql->bindParam(7, $this->formaPago);
            $sql->bindParam(8, $this->estadoPedido);
            $sql->bindParam(9, $this->estado);
            $sql->execute();

            // Obtener el ID del pedido generado
            $idPedido = $this->conexion->getCon()->lastInsertId();

            return $idPedido;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    function agregarDatosPokemones()
    {
        try {
            $this->estadoP = 'A';

            $sql = $this->conexion->getCon()->prepare("INSERT INTO pedprod(idPed, idPo, cantidadPoke, estado) VALUES (?, ?, ?, ?)");
            $sql->bindParam(1, $this->idPed);
            $sql->bindParam(2, $this->idPo);
            $sql->bindParam(3, $this->cantidadPoke);
            $sql->bindParam(4, $this->estadoP);

            $sql->execute();
            return "Datos de pokemones agregados correctamente";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    function disminuirCantidadPokemones()
    {
        try {
            $sql = $this->conexion->getCon()->prepare("UPDATE pokemones SET cantidadPo = cantidadPo - (SELECT SUM(cantidadPoke) FROM pedprod WHERE idPo = ? AND idPed = (SELECT MAX(idPed) FROM pedprod)) WHERE id = ?");
                                                    
            $sql->bindParam(1, $this->idPo);
            $sql->bindParam(2, $this->idPo);
            $sql->execute();
        } catch (PDOException $e) {
            return "Error al disminuir la cantidad de pokemones: " . $e->getMessage();
        }
    }    

    /**
     * Get the value of idPed
     */
    public function getIdPed()
    {
        return $this->idPed;
    }

    /**
     * Set the value of idPed
     *
     * @return  self
     */
    public function setIdPed($idPed)
    {
        $this->idPed = $idPed;

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
     * Get the value of cantidadPo
     */
    public function getCantidadPoke()
    {
        return $this->cantidadPoke;
    }

    /**
     * Set the value of cantidadPo
     *
     * @return  self
     */
    public function setCantidadPoke($cantidadPoke)
    {
        $this->cantidadPoke = $cantidadPoke;

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
     * Get the value of codigoPed
     */
    public function getCodigoPed()
    {
        return $this->codigoPed;
    }

    /**
     * Set the value of codigoPed
     *
     * @return  self
     */
    public function setCodigoPed($codigoPed)
    {
        $this->codigoPed = $codigoPed;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of totalPedido
     */
    public function getTotalPedido()
    {
        return $this->totalPedido;
    }

    /**
     * Set the value of totalPedido
     *
     * @return  self
     */
    public function setTotalPedido($totalPedido)
    {
        $this->totalPedido = $totalPedido;

        return $this;
    }

    /**
     * Get the value of formaPago
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * Set the value of formaPago
     *
     * @return  self
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get the value of estadoPedido
     */
    public function getEstadoPedido()
    {
        return $this->estadoPedido;
    }

    /**
     * Set the value of estadoPedido
     *
     * @return  self
     */
    public function setEstadoPedido($estadoPedido)
    {
        $this->estadoPedido = $estadoPedido;

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
}
