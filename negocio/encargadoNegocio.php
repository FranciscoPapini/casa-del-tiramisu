<?php
/*Clase Datos*/
require_once('datos/encargadoDb.php');

class EncargadoNegocio{
  
    public function listar(){
        $db = new EncargadoDb();
        return $db->getAll();
    }
  
    public function recuperar($id){
        $db = new EncargadoDb();       
        return $db->getOne($id);
    }

    public function login($user, $password){
        $db = new EncargadoDb();       
        return $db->login($user,$password);
    }

    public function validarUser($user){
        $db = new EncargadoDb();
        return $db->checkEncargado($user);
    }

   public function guardar(){

      $_POST['nombre'] = strtolower($_POST['nombre']);
      $_POST['apellido'] = strtolower($_POST['apellido']);
      $_POST['email'] = strtolower($_POST['email']);
        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;
        $confPassword = $datos['confpassword'];

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $encargado = new Encargado($datos);
            $db = new EncargadoDb();
            if($encargado->getId()){
                if(Util::validarPassword($encargado->getPassword(), $confPassword)){
                    if( $db->update($encargado) instanceof Encargado ){
                        Util::setMsj('El encargado fue actualizado con &eacute;xito','success');
                    }else{
                        Util::setMsj('Hubo un problema actualizando el encargado','danger');
                    }
                    header('Location:?modulo=encargado&accion=listar');
                    die();
            }else{
                    Util::setMsj('Las contraseñas no coinciden','danger');
                    header('Location:?modulo=encargado&accion=editar&id='.$encargado->getId());
                    die();
            }
        }else{
                if( $db->checkEncargado($encargado->getUsuario()) ){
                    if(Util::validarPassword($encargado->getPassword(), $confPassword)){
                    if( $db->insert($encargado) instanceof Encargado ){
                        Util::setMsj('El encargado fue insertado con &eacute;xito','success');
                    }else{
                        Util::setMsj('Hubo un problema insertando el encargado','danger');
                        }
                    header('Location:?modulo=encargado&accion=listar');
                    die();
                    }else{
                    Util::setMsj('Las contraseñas no coinciden','danger');
                    header('Location:?modulo=encargado&accion=editar');
                    die();
            }
                }
                else{
                        Util::setMsj('El usuario <strong>'.$encargado->getUsuario().'</strong> ya existe. Intente con otro usuario','danger');
                        return false;
                    }

                }

        }
        else{
        //si hay algun error, informar por pantalla
        }

    }

    public function eliminar(){

        //validar los campos recibidos por $_POST
        $valido = true;
        $datos = $_POST;

        if($valido){
        //si todo está ok, guardar en BD e informar por pantalla
            $encargado = new Encargado($datos);
            $db = new EncargadoDb();

            if( $db->remove($encargado)){
                Util::setMsj('El encargado <strong>'.$_POST['encargado'].'</strong> fue eliminado con &eacute;xito','success');
            }else{
                Util::setMsj('Hubo un problema eliminando el encargado','danger');
            }
            header('Location:?modulo=encargado&accion=listar');
            die();
        }else{
        //si hay algun error, informar por pantalla
        }
    }

}

?>