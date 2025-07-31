<?php

class Util{
    
    static function dbToDate($db){
        return implode('/',array_reverse(explode('-',$db)));
    }

    static function dateToDb($date){
        return implode('-',array_reverse(explode('/',$date)));
    }

    static function validar(){
    	    //^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$
    }

    static function setMsj($msj, $tipo = 'info', $dismissable = true){
    	$_SESSION['mensaje']['texto'] = $msj;
    	$_SESSION['mensaje']['tipo'] = $tipo;
        $_SESSION['mensaje']['dismissable'] = $dismissable;
    }

    static function getMsj(){
    	if($_SESSION['mensaje']){
            $aux1 = '';
            $aux2 = '';
            if($_SESSION['mensaje']['dismissable']){
             $aux1 = 'alert-dismissible';
             $aux2 = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            }
	    	$return = '<div class="alert alert-'.$_SESSION['mensaje']['tipo'].' '.$aux1.'" role="alert">'.$aux2.''.$_SESSION['mensaje']['texto'].'</div>';
	  		unset($_SESSION['mensaje']);
	  		return $return;
    	}
    }

    static function validarPassword($password, $confPassword){
        if($password == $confPassword){
            return true;
        }
        else{
            return false;
        }
    }
}

?>