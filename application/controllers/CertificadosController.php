<?php

class CertificadosController extends Zend_Controller_Action
{
    
    const PATH_INDEX = '/certificados';

    public function init()
    {
        // Verifica que sea un usuario logueado para poder acceder al controlador.
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect("/");
        }
    }

    public function indexAction()
    {
        $this->_redirect("/");
    }

    public function laboralAction()
    {         
        // Carga las clases necesarias para generar el archivo PDF.
        Zend_Loader::loadFile('tcpdf.php', APPLICATION_PATH . '/../library/tcpdf');
        Zend_Loader::loadClass('ValoresToLetras', APPLICATION_PATH . '/../library/util');        
        
        $outDto = new stdClass();
        $outDto->existe = false;        
        // Crear el formulario de consulta.
        $form = new Application_Form_CertificadosLaboralFiltro();
        $esAdministrador = true;
        // Validar que el usuario logueado es un administrador o no.
        $usuario = $this->_helper->sesionActual('usuario');
        if($usuario->idPerfil != Application_Model_Perfiles::ADM){
            $esAdministrador = false;
            $persona = $this->_helper->sesionActual('persona');
            $tipoDocumento = $persona->tipoDocumento;
            $numeroDocumento = $persona->numeroDocumento;            
            // Desabilita en el formulario la edicion de los campos tipo y numero de documento.
            $form->getElement('tipoDocumento')
                    ->setAttrib('disabled', 'disabled')
                    ->setValue($tipoDocumento);
            $form->getElement('numeroDocumento')
                    ->setAttrib('disabled', 'disabled')
                    ->setValue($numeroDocumento);                        
        } 
        // Validar que la peticion es POST.
        if($this->getRequest()->isPost()) { 
            // Recuperar los datos POST.
            $post = $this->getRequest()->getPost(); 
            if(!$esAdministrador) {
                $post['tipoDocumento'] = $tipoDocumento;
                $post['numeroDocumento'] = $numeroDocumento;
            }
            // Validar si los valores del formulario son correctos.
            if($form->isValid($post)) {                
                $t_personas = new Application_Model_Personas();
                $filaPersona = $t_personas->getCertificacionLaboralInformacion($post['tipoDocumento'], $post['numeroDocumento']);                                                            
                // Validar que exista la persona digitada.
                if($filaPersona == false) {                
                    $this->_helper->mensajes('E', "El usuario no existe, verifique los datos ingresados [<b>{$post['tipoDocumento']} {$post['numeroDocumento']}</b>] ");
                    $outDto->existe = false;                
                } else {                 
                    $outDto->existe = true;                                    
                    // Se crea el objeto PDF.
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'LETTER', true, 'UTF-8', false);
                    // Se agrega protección anticopia al objeto PDF.
                    $pdf->SetProtection(array('modify','copy'));
                    // Se agregan metadatos al objeto PDF.
                    $pdf->SetCreator('SGEM');
                    $pdf->SetAuthor('Deposito Principal de Drogas - Incolsoft');
                    $pdf->SetTitle('Certificación laboral');
                    $pdf->SetSubject('Certificación laboral');
                    $pdf->SetKeywords('DPD, Incolsoft, certificación');
                    // Se agrega la imagen a la cabecera del documento PDF.
                    $pdf->SetHeaderData('logo_incolsoft_transparente.png', 70, '', '');
                    
                    $pdf->setPrintHeader(true);
                    $pdf->setPrintFooter(false);
                    // Se configuran opciones de margenes y fin de pagina.
                    $pdf->SetMargins(35, 40);
                    $pdf->SetAutoPageBreak(TRUE, 35);                
                    // Se agrega una hoja al documento PDF.
                    $pdf->AddPage();                                    
                    // Se establece configuracion de la fuente.
                    $pdf->SetFont('times', 'B', 20);
                    $pdf->Write(0, "CERTIFICA QUE:", '', 0, 'C');
                    $pdf->Ln(30);                  
                    // Se establece configuracion de la fuente.
                    $pdf->SetFont('times', '', 13);
                    $valorEnLetras = ValoresToLetras::convertirNumero($filaPersona['salario']);

                    $nombreTotal = sprintf("%s%s%s%s", 
                                !empty($filaPersona['primerApellido'])? $filaPersona['primerApellido']." ": '',
                                !empty($filaPersona['segundoApellido'])? $filaPersona['segundoApellido']." ": '',
                                !empty($filaPersona['primerNombre'])? $filaPersona['primerNombre']." ": '',
                                !empty($filaPersona['segundoNombre'])? $filaPersona['segundoNombre']." ": ''
                            );                                
                    list($anio, $mes, $dia) = explode("-", $filaPersona['fechaIngreso']);
                    $txt = trim($nombreTotal)." identificado con tipo y numero de documento {$filaPersona['tipoDocumento']} {$filaPersona['numeroDocumento']} labora en esta compañia desde {$dia} de ".fnMesNombre($mes)." de {$anio} desempeñando el cargo de {$filaPersona['nombreCargo']} devengando una compensación total de ".$valorEnLetras." PESOS M/CTE (".fnFormatoNumero($filaPersona['salario']).").";
                    $pdf->Write(0, $txt, '', false, 'J', false, 1);                
                    $pdf->Ln(20);
                    $pdf->Write(0, "El tipo de contrato es {$filaPersona['nombreTipoContrato']}");
                    $pdf->Ln(30);
                    list($anio, $mes, $dia) = explode("-", date('Y-m-d'));
                    $pdf->Write(0, "La presente se expide a solicitud del interesado el {$dia} de ".fnMesNombre($mes)." de {$anio} en la ciudad de bogotá, con destino ".$post['dirigido']);
                    $pdf->Ln(50);          
                    // Se agrega imagen de firma y sello.
                    $pdf->Image('img/firma.png'); 
                    $pdf->Ln(20);
                    $pdf->Write(0, "Persona que firma"); 
                    $pdf->Ln();
                    $pdf->Write(0, "Depto. Recursoso Humanos");                                                
                    $ruta = "tmp/".date("Ymd")."-RRHHCL-".$post['numeroDocumento'].".pdf";                
                    $pdf->Output($ruta, 'F');                
                    $outDto->pdfPath = $ruta;                                 
                    $outDto->pdfName = basename($ruta);                                 
                }
            } else {
                $this->_helper->mensajes('E', "Error en los datos ingresados.");
                $outDto->existe = false;
            }
        }
        
        $outDto->form = $form;
        $outDto->esAdministrador = $esAdministrador;
        $this->view->outDto = $outDto;
    }

}
