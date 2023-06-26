<?php

namespace modelo;

use Exception;
use PDOException;

include_once "conexion.php";

class Usuario
{
    private $id;
    private $tipoDoc;
    private $identificacion;
    private $nombre;
    private $apellido;
    private $correo;
    private $password;
    private $direccion;
    private $telefono;
    private $genero;
    private $idRol;
    private $estado;
    public $conexion;

    function __construct()
    {
        $this->conexion = new \Conexion();
    }

    function createUsuario()
    {
        try {
            $sql = $this->conexion->getCon()->prepare("INSERT INTO usuario(tipoDoc,identificacion,nombre,apellido,correo,
        password,direccion,telefono,genero,idRol,estado) VALUES (?,?,?,?,?,?,?,?,?,(SELECT id FROM rol WHERE nombreRol = 'Usuario'),'A')");
            $sql->bindParam(1, $this->tipoDoc);
            $sql->bindParam(2, $this->identificacion);
            $sql->bindParam(3, $this->nombre);
            $sql->bindParam(4, $this->apellido);
            $sql->bindParam(5, $this->correo);
            $sql->bindParam(6, $this->password);
            $sql->bindParam(7, $this->direccion);
            $sql->bindParam(8, $this->telefono);
            $sql->bindParam(9, $this->genero);
            $sql->execute();
            return "Usuario Agregado Correctamente";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function login()
    {
        try {
            $sql = $this->conexion->getCon()->prepare("SELECT * FROM usuariorol WHERE correo=? AND password=?");
            $sql->bindParam(1, $this->correo);
            $sql->bindParam(2, $this->password);
            $sql->execute();
            $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
            if (isset($result) and !empty($result)) {
                session_start();
                $_SESSION["nombre"] = $result[0]["nombre"];
                $_SESSION["rol"] = $result[0]["idRol"];
            }
            return $result;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Get the value of i
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of tipoDoc
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * Set the value of tipoDoc
     */
    public function setTipoDoc($tipoDoc): self
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * Get the value of identificacion
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set the value of identificacion
     */
    public function setIdentificacion($identificacion): self
    {
        $this->identificacion = $identificacion;

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
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellido
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     */
    public function setApellido($apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of correo
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     */
    public function setCorreo($correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

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
     */
    public function setDireccion($direccion): self
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
     */
    public function setTelefono($telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set the value of genero
     */
    public function setGenero($genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set the value of rol
     */
    public function setRol($idRol): self
    {
        $this->idRol = $idRol;

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
     */
    public function setEstado($estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of conexion
     */
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * Set the value of conexion
     */
    public function setConexion($conexion): self
    {
        $this->conexion = $conexion;

        return $this;
    }
}
