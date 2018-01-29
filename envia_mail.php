<?php 
function form_mail($sPara, $sAsunto, $sTexto, $sDe, $file, $name_file)
{ 
	$sCabeceraTexto = "";
    $sAdjuntos = "";
    $sCuerpo = $sTexto;
    $sSeparador = uniqid("_Separador-de-datos_");

    $sCabeceras = "MIME-version: 1.0\n";


    // Cabeceras generales del mail 
    $sCabeceras .= "Content-type: multipart/mixed;";
    $sCabeceras .= "boundary=\"".$sSeparador."\"\n";

    // Cabeceras del texto 
    $sCabeceraTexto = "--".$sSeparador."\n";
    $sCabeceraTexto .= "Content-type: text/html;charset=iso-8859-1\n";
    $sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n\n";

    $sCuerpo = $sCabeceraTexto.$sCuerpo;

    $sAdjuntos .= "\n\n--".$sSeparador."\n";
    $sAdjuntos .= "Content-type: pdf;name=\"".$name_file."\"\n";
    $sAdjuntos .= "Content-Transfer-Encoding: BASE64\n";
    $sAdjuntos .= "Content-disposition: attachment;filename=\"".$name_file."\"\n\n";

    $oFichero = fopen($file, 'rb');
    $sContenido = fread($oFichero, filesize($file));
    $sAdjuntos .= chunk_split(base64_encode($sContenido));
    fclose($oFichero);

    $sCuerpo .= $sAdjuntos."\n\n--".$sSeparador."--\n";

    // Se añade la cabecera de destinatario 
    if ($sDe)$sCabeceras .= "From:".$sDe."\n";

    // Por último se envia el mail 
    return(mail($sPara, $sAsunto, $sCuerpo, $sCabeceras));
}
?>