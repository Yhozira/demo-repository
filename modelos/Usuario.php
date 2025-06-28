
<?php
class Usuario {
    public $id;
    public $nombre;
    public $correo;
    public $tipo;

    // Constructor
    public function __construct($id, $nombre, $correo, $tipo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->tipo = $tipo;
    }
}
