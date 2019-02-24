<?php

class Cesta {

    private $productos = [];
    private $total;

    /** Devuelve la cesta con distinto formato según si ya existe o no
     * @return Cesta como objeto o como variable de sesión
     */
    public static function generaCesta() {
        if (isset($_SESSION['cesta'])) {
            return $_SESSION['cesta'];
        } else {
            return new Cesta();
        }
    }

    /** Funcion que construye el contenido de la cesta con HTML 
     * según el contenido del atributo productos
     * @return string con el HTML
     */
    public function mostrarCesta() {
        if ($this->productos == null || $this->productos == 0) {
            $contenidoCesta .= "<p class='cestaVacia'>0 PRODUCTOS</p>";
        }
        $contenidoCesta = "";
        foreach ($this->productos as $codigo => $valores) {
            $contenidoCesta .= "<p>"
                    . "<span class='cantidad'>$valores[0]</span> "
                    . "<span class='codigo'>$codigo</span> "
                    . "<span class='precio'>$valores[1]</span>"
                    . "<form action='sitio.php' method='POST'>"
                    . "<input type='hidden' name='codigo' value='$codigo'>"
                    . "<input type='submit' name='cestaAccion' value='Eliminar'><br/>"
                    . "</form>"
                    . "</p>";
        }
        $contenidoCesta .= "<hr>"
                . "<p><span class='total1'>Total:</span><span class='total2'>" . $this->calculoTotal() . "</span><br/></p>";
        return $contenidoCesta;
    }

    /** Funcion que comprueba si el producto ya existe en el array productos, 
     * si no existe lo añade con sus datos y si sí solo le suma uno a su cantidad
     * @param type $precio
     * @param type $codigo
     */
    public function nuevoProd($precio, $codigo) {
        if ($this->productos[$codigo][0] > 0) {
            $this->productos[$codigo][0] ++;
        } else {
            $this->productos[$codigo][0] = 1;
            $this->productos[$codigo][1] = $precio;
        }
    }

    /** calcula el precio total a pagar cogiendo los datos del array productos
     * @return type
     */
    public function calculoTotal() {
        foreach ($this->productos as $producto => $valores) {
            $cantidad = $valores[0];
            $precio = $valores[1];
            $this->total += ($cantidad * $precio);
        }
        return $this->total;
    }

    //guardamos cesta en una variable de sesion
    public function guardaCesta() {
        $_SESSION['cesta'] = $this;
    }

}
