
<?php
class Pedido {
    public $id;
    public $usuario_id;
    public $estado;
    public $total;

    // Constructor
    public function __construct($id, $usuario_id, $estado, $total) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->estado = $estado;
        $this->total = $total;
    }
}
