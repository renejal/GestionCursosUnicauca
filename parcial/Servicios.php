<?php
include("Materia.php");
include("Estudiante.php");
    class Servicios{

        function crear_json($codigo){
            $archivo_codigo = './Estudiantes/'.$codigo.'.json'; 
            
            if (file_exists('/Estudiantes')){
                return '<div><h1>Contacte con el administrador.</h1</div>';
            }
            //return '<div><h1>'.htmlspecialchars($archivo_codigo).'</h1</div>';
            if (!file_exists($archivo_codigo)){
                //crear el archivo json
                $estudiante = self::crear_estudiante_defecto();
                $materias=self::convertir_estudiante_json($estudiante);
                file_put_contents($archivo_codigo,$materias);
            }
            $datos_estudiante=file_get_contents($archivo_codigo);
            $json_estudiante=json_decode($datos_estudiante,true);
            return self::obtener_code_html($json_estudiante,$codigo);
        }
        function convertir_estudiante_json($estudiante){
            $materias=json_encode($estudiante);
            return $materias;
        }
        /*function convertir_json_estudiante($archivo_codigo){
            $datos_estudiante=file_get_constents($archivo_codigo);
            $json_estudiante=json_decode($datos_estudiante,true);
            return $json_estudiante;
        }*/
        function crear_estudiante_defecto(){
             //Agregando materias
             //Semestre #1
             $materia_1=new Materia('Itroducción a la Informatica', '1001','4','1',false);
             $materia_2=new Materia('Lba de Introduccón a la Informatica', '1002','1','1',false);
             $materia_3=new Materia('Cálculo I', '1003','4','1',false);
             $materia_4=new Materia('Electiva FiSH I','1004','2','1',false);
             $materia_5=new Materia('Lectoescritua', '1005','2','1',false);
             $materia_6=new Materia('Itroducción a la Ingeniería', '1006','2','1',false);
            
             //Semestre #2
             $materia_7=new Materia('Porgramación Orientada a Objetos', '1007','4','2',false);
             $materia_8=new Materia('lba de Programación Orientada a Objetos', '1008','1','2',false);
             $materia_9=new Materia('Cálculo II', '1009','4','2',false);
             $materia_10=new Materia('Electromagnetismo', '1010','2','4',false);
             $materia_11=new Materia('lba de Electromagnetismo', '1011','1','2',false);
             $materia_12=new Materia('Algebra Lineal', '1012','3','2',false);
             
            //Semestre 3
             $materia_13=new Materia('Porgramación Orientada a Objetos', '1013','4','3',false);
             $materia_14=new Materia('lba de Programación Orientada a Objetos', '1014','1','3',false);
             $materia_15=new Materia('Cálculo II', '1015','4','3',false);
             $materia_16=new Materia('Electromagnetismo', '1016','4','3',false);
             $materia_17=new Materia('lba de Electromagnetism', '1017','1','3',false);
             $materia_18=new Materia('Algebra Lineal', '1018','3','3',false);
             
            //Semestre 4
             $materia_19=new Materia('Porgramación Orientada a Objetos', '1019','4','4',false);
             $materia_20=new Materia('lba de Programación Orientada a Objetos', '1020','1','4',false);
             $materia_21=new Materia('Cálculo II', '1021','4','4',false);
             $materia_22=new Materia('Electromagnetismo', '1022','4','4',false);
             $materia_23=new Materia('lba de Electromagnetismo', '1023','1','4',false);
             $materia_24=new Materia('Algebra Lineal', '1024','3','4',false);
             $materias_=[$materia_1,$materia_2,$materia_3,$materia_4,$materia_5,$materia_6,$materia_7,$materia_8,$materia_9,$materia_10,$materia_11,$materia_12,$materia_13,$materia_14,$materia_15,$materia_16,$materia_17,$materia_18,$materia_19,$materia_20,$materia_21,$materia_22,$materia_23,$materia_24];
             
             $estudiante=new Estudiante();
             $estudiante->materias=$materias_;
             return $estudiante;
        }
        function obtener_code_html($estudiante,$codigo){
            $estudiante1=$estudiante['materias'];
            $div_contenedor='<div class="container">';
            
            for ($i = 1; $i <= 10; $i++) {
                $semestre=self::armar_semestre((string)$i, $estudiante1,$codigo);
                $div_contenedor=$div_contenedor.$semestre;
            }
            $div_contenedor=$div_contenedor."</div>";

            return $div_contenedor;
        }

        function armar_semestre($num_semestre, $estudiante1,$codigo){
            $count=0;
            $div_p='<br><div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Semestre '.htmlspecialchars($num_semestre).'</h5>
                            <div  class="card-tex t">
                                <table class="table table table-border table-hover">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Codigo</th> 
                                        <th>Creditos</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>';

            foreach($estudiante1 as $valor){
                //acomodar id, darle un mejor nombre al button
                if (strcmp($num_semestre, $valor['semestre'])==0){
                    $estilo= $valor['estado']?'<strike>Terminada</strike>':'Sin Terminar';
                    $div_p=$div_p.'<tr id= "_'.$codigo.'_'.$valor['codigo'].'">
                                    <td>'.$valor['nombre'].'</td>
                                    <td>'.$valor['codigo'].'</td>
                                    <td>'.$valor['creditos'].'</td>
                                    <td class="text-secondary">'.$estilo.'</td>
                                    <td><button id="'.$codigo.'_'.$valor['codigo'].'"onclick="cambiar_estado_materia(this)" type="button" class="btn btn-primary btn-lg active">Cambiar estado</button></td>
                                    </tr>';
                    $count=1;
                }
            }
            $div_p=$div_p.' </table>
                        </div>
                    </div>
                </div><br>';
            if ($count==1){
                return $div_p;
            }else{
                return '';
            }
        }

        function cambiar_estado_materia($id_codigo){
            $ids = explode("_", $id_codigo);
            $dir='./Estudiantes/'.$ids[0].'.json';
            if (file_exists($dir)){
                
                $datos_estudiante=file_get_contents($dir);
                $json_estudiante=json_decode($datos_estudiante,true);
                
                self::cambiar_estado($json_estudiante,$ids,$dir);

                $datos_estudiante=file_get_contents($dir);
                $json_estudiante=json_decode($datos_estudiante,true);
                $estudiante1=$json_estudiante['materias'];
                
                foreach($estudiante1 as $valor){
                    //acomodar id, darle un mejor nombre al button
                    if (strcmp($ids[1], $valor['codigo'])==0){
                        $html='';
                        $estilo= $valor['estado']?'<strike>Terminada</strike>':'Sin Terminar';
                        $html=$html.'<tr id= "_'.$ids[0].'_'.$valor['codigo'].'">
                                        <td>'.$valor['nombre'].'</td>
                                        <td>'.$valor['codigo'].'</td>
                                        <td>'.$valor['creditos'].'</td>
                                        <td class="text-secondary">'.$estilo.'</td>
                                        <td><button id="'.$ids[0].'_'.$valor['codigo'].'"onclick="cambiar_estado_materia(this)" type="button" class="btn btn-primary btn-lg active">Cambiar estado</button></td>
                                        </tr>';
                        return $html;
                    }
                }
            }
         
            return 'Contacte con el administrador.';
        }

        function cambiar_estado($json_estudiante,$ids,$dir){
            $estudiante1=$json_estudiante['materias'];
            $count=0;

            for ($x=0;$x<count($estudiante1);$x++){
                if (strcmp($ids[1], $estudiante1[$x]['codigo'])==0){
                    $aux=$estudiante1[$x]['estado']?false:true;
                    $estudiante1[$x]['estado']=$aux;
                    break; 
                }   
            }
            $array_new=array('materias'=>$estudiante1);
            $json_new=json_encode($array_new);
            file_put_contents($dir,$json_new);
        }
        function cambio($s){
            if ($s){
                $s=false;
            }else{
                $s=true;
            }
        }
       
    }
?>