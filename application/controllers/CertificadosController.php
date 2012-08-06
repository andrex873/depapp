<?php

class CertificadosController extends Zend_Controller_Action
{        

    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect("/");
        }
    }

    public function indexAction()
    {
    }

    public function laboralAction()
    { 
        //Zend_Loader::loadClass('TCPDF', APPLICATION_PATH . '/../library/tcpdf');
        Zend_Loader::loadFile('tcpdf.php', APPLICATION_PATH . '/../library/tcpdf');
        Zend_Loader::loadClass('ValoresToLetras', APPLICATION_PATH . '/../library/util');        
        
        $outDto = new stdClass();
        $outDto->existe = false;        
        $form = new Application_Form_CertificadosLaboralFiltro();
        if($this->getRequest()->isPost()){             
            $post = $this->getRequest()->getPost();
            if($form->isValid($post)){
                $t_personas = new Application_Model_Personas();
                $filaPersona = $t_personas->getCertificacionLaboralInformacion($post['tipoDocumento'], $post['numeroDocumento']);                                                            
                if($filaPersona == false){                
                    $this->_helper->mensajes('E', "El usuario no existe, verifique los datos ingresados [<b>{$post['tipoDocumento']} {$post['numeroDocumento']}</b>] ");
                    $outDto->existe = false;                
                }else{                 
                    $outDto->existe = true;                                    

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'LETTER', true, 'UTF-8', false);

                    $pdf->SetProtection(array('modify','copy'));
                    $pdf->SetCreator('Incolsoft');
                    $pdf->SetAuthor('Incolsoft');
                    $pdf->SetTitle('Certificación laboral');
                    $pdf->SetSubject('Certificación laboral');
                    $pdf->SetKeywords('Incolsoft, PDF, certificación');

                    $pdf->SetHeaderData('logo_incolsoft_transparente.png', 70, '', '');
                    
                    $pdf->setPrintHeader(true);
                    $pdf->setPrintFooter(false);

                    $pdf->SetMargins(35, 40);
                    $pdf->SetAutoPageBreak(TRUE, 35);                

                    $pdf->AddPage();                                    

                    $pdf->SetFont('times', 'B', 20);
                    $pdf->Write(0, "CERTIFICA QUE:", '', 0, 'C');
                    $pdf->Ln(30);                  
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
                    $pdf->Image('img/firma.png'); 
                    $pdf->Ln(20);
                    $pdf->Write(0, "Persona que firma"); 
                    $pdf->Ln();
                    $pdf->Write(0, "Depto. Recursoso Humanos");                                                
                    $ruta = "tmp/RRHHCL001.pdf";                
                    $pdf->Output($ruta, 'F');                
                    $outDto->pdfPath = $ruta;                                 
                }
            } else {
                $this->_helper->mensajes('E', "Error en los datos ingresados.");
                $outDto->existe = false;
            }
        }
        $outDto->form = $form;
        $this->view->outDto = $outDto;
    }

}

