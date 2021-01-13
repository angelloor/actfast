<?php /*defined in examplemyclass.php*/


class MySql
{
    private $dbc;
    private $user;
    private $pass;
    private $dbname;
    private $host;


    function __construct($host = "localhost", $dbname = "actfast", $user = "root", $pass = "sysadmin")
    {

        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->host = $host;
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try {
            $this->dbc = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $user, $pass, $opt);
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "Hubo problemas con el usuario o la contraseña para acceder a la base de datos. ";
        }
    } /*end function*/


    public function backup_tables($tables = '*')
    {  /* backup the db OR just a table */
        $host = $this->host;
        $user = $this->user;
        $pass = $this->pass;
        $dbname = $this->dbname;
        $data = "SET SQL_MODE  = 'NO_AUTO_VALUE_ON_ZERO';\n  ";
        $data .= "SET time_zone = '+00:00'; \n";
        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = $this->dbc->prepare('SHOW TABLES');
            $result->execute();

            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables); //Si backup_tables tiene una tabla en concreto como parametro
        }
        //cycle through

        $cols = array();

        foreach ($tables as $table) {

            //  echo "var dump cols =";
            // echo "La tabla es actual es:";

            $columns = $this->dbc->prepare('SELECT * FROM ' . $table);
            $columns->execute();
            $cols_numero = $columns->columnCount();
            //var_dump("Cols_numero =".$cols_numero . "<br>");
            $resultcount = $this->dbc->prepare('SELECT count(*) FROM ' . $table); //Devuelve el numero de filas en la tabla x
            $resultcount->execute(); //Eejecutamos la consulta.
            $num_fields = $resultcount->fetch(PDO::FETCH_NUM);
            $num_fields = $num_fields[0];

            // echo "<hr>";

            ///*** final del conteo se almacena en una variable  ***/////

            $result = $this->dbc->prepare('SELECT * FROM ' . $table);
            $result->execute();
            $data .= 'DROP TABLE ' . $table . ';';
            $result2 = $this->dbc->prepare('SHOW CREATE TABLE ' . $table);
            $result2->execute();
            $row2 = $result2->fetch(PDO::FETCH_NUM);
            $data .= "\n\n" . $row2[1] . ";\n\n"; // Consulta Sql para crear las tablas
            ////////////////////////////////////////
            $show_cols = $this->dbc->prepare("SHOW columns from  $table");
            $show_cols->execute();

            if ($num_fields == 0) {

                $data .= "\n";
            } else {

                $data .= "INSERT INTO `" . $table . "`(";

                $cuenta_columnas = 0;
                while ($col = $show_cols->fetch(PDO::FETCH_NUM)) {
                    $cuenta_columnas++;

                    for ($e = 0; $e < $cols_numero; $e++) {
                        if ($e < ($cols_numero - 1)) {
                            /*echo 'A';*/
                        } else {
                            /*echo'_';*/
                        }
                        //echo" 1 -El valor de e es:$e  (<) $cols_numero <br>" ;
                    }

                    if (isset($col[0])) {
                        $data .= "`" . $col[0] . "`";
                    }

                    if ($cuenta_columnas == $cols_numero) {
                        $data .= "";
                    } else {
                        $data .= ',';
                    }
                    // if (!$e < ($cols_numero -1 )) { $data.= ','; } else{$data.= '9';}  //agregamos una coma entre campos

                }
                ////////////////////////////////////

                $data .= ') VALUES ';
                $cuenta = 0;
                while ($row = $result->fetch(PDO::FETCH_NUM)) {
                    $cuenta++;
                    $data .= "\n(";

                    for ($j = 0; $j < $cols_numero; $j++) {
                        //var_dump($row[$j]);
                        $row[$j] = addslashes($row[$j]);    //Escapamos caracteres especiales
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        //echo" 2 - El valor de $j es:$j  (<) $cols_numero <br>" ;

                        if (isset($row[$j])) {
                            $data .= "'" . $row[$j] . "'";
                        } else {
                            $data .= '"8888"';
                        }

                        // if ($j<($cols_numero -1 )) { echo 'C'; } else{echo'_';}
                        if ($j < ($cols_numero - 1)) {
                            $data .= ',';
                        } elseif ($cuenta == $num_fields) {
                            $data .= "";
                        } else {
                            $data .= "),\n";
                        }  //agregamos una coma entre campos
                    }
                }
                $data .= ");\n";
            }
        }
        $data .= "\n\n\n";

        //save filename
        $filename = 'actfast.sql';
        $this->writeUTF8filename($filename, $data);
        /*USE EXAMPLE
           $connection = new MySql(SERVERHOST,"your_db_name",DBUSER, DBPASS);
           $connection->backup_tables(); //OR backup_tables("posts");
           $connection->closeConnection();
        */
    } /*end function*/


    private function writeUTF8filename($filenamename, $content)
    {  /* save as utf8 encoding */
        $f = fopen($filenamename, "w+");
        # Now UTF-8 - Add byte order mark
        fwrite($f, pack("CCC", 0xef, 0xbb, 0xbf));
        fwrite($f, $content);
        fclose($f);

        $archivos = scandir("./");
        $num = 0;
        for ($i = 2; $i < count($archivos); $i++) {
            $num++;
                echo '
                
<!doctype html>
<html lang="es">
  <head>
    <title>BackUp BD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descriptions" content="Sistema para la generación de actas y control de inventario CNE - Delegación Pastaza">
    <meta name="author" content="Angel Miguel Loor Manzano - CODERS">
    <link rel="icon" type="image/png" href="../assets/img/logo.png"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- SCRIPTS -->
    <script src="../assets/js/all.min.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css"> 
  </head>
  <body class="body-backup">

<table>
    <tbody>
        <tr>
            <td>'.$archivos[$i].'</td>
            <td><a title="Descargar Archivo" href="./'.$archivos[$i].'" download="'.$archivos[$i].'"> <span class="fas fa-download" aria-hidden="true"></span> </a></td>
            <!-- <td><a title="Eliminar Archivo" href="Eliminar.php?name=/'.$archivos[$i].'" onclick="return confirm("Esta seguro de eliminar el archivo?");"> <span class="fas fa-trash-alt" aria-hidden="true"></span> </a></td> -->
        </tr>
    </tbody>
</table>
</body>
</html>';
if($i == 2 ){
    return;
}
            
}

        /*USE EXAMPLE this is only used by public function above...
            $this->writeUTF8filename($filename,$data);
        */
    } /*end function*/

    // OjO aqui en esta funcion puedes incorporar el codigho para inportar la base de datos  OjO
    // Puedes hacer un formulario y acomodar todo en el front end
    public function recoverDB($filePath)
    {
        echo "write some code to load and proccedd .sql file in here ...";

        /*USE EXAMPLE this is only used by public function above...
            recoverDB("some_buck_up_file.sql");
        */
    } /*end function*/


    public function closeConnection()
    {
        $this->dbc = null;
        //EXAMPLE OF USE
        /*$connection->closeConnection();*/
    }/*end function*/
} /*END OF CLASS*/
?>