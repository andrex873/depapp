<?php

class CertificadosController extends Zend_Controller_Action
{

    private $msg    = null;

    public function init()
    {
        //$this->msg = $this->_helper->FlashMessenger;                
    }

    public function indexAction()
    {
        // action body
    }

    public function laboralAction()
    {        
        Zend_Loader::loadClass('TCPDF', APPLICATION_PATH . '/../library/tcpdf');
        Zend_Loader::loadClass('ValoresToLetras', APPLICATION_PATH . '/../library/util');        
        
        $outDto = new stdClass();
        $outDto->existe = false;
        if($this->getRequest()->isPost()){
            
            $post = $this->getRequest()->getPost();
            $t_personas = new Application_Model_Personas();
            $filaPersona = $t_personas->getCertificacionLaboralInformacion($post['tipoDocumento'], $post['numeroDocumento']);                                                            
            if($filaPersona == false){
                $msg = array('status' => 'E', 'msg' => 'El usuario no existe');
                $outDto->existe = false;
                $outDto->msg = $msg;                
                //$this->_helper->FlashMessenger("error");
            }else{
                $msg = array('status' => 'S', 'msg' => 'El usuario correcto');
                $outDto->existe = true;
                $outDto->msg = $msg;                
                $outDto->filaPersona = $filaPersona;                
                //$this->_helper->FlashMessenger("correcto");
                
                
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
                
                $pdf->SetCreator('Incolsoft');
                $pdf->SetAuthor('Incolsoft');
                $pdf->SetTitle('Certificación laboral');
                $pdf->SetSubject('Certificación laboral');
                $pdf->SetKeywords('Incolsoft, PDF, certificación');
                
                //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                
                //$pdf->SetDefaultMonospacedFont('arial');                
                $pdf->SetMargins(40, 40, 40);
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);                
                                                
                $pdf->AddPage();                
                $pdf->Image("img/incolsoft_blancol.jpg");                
                $pdf->Ln(40);
                                                
                $pdf->SetFont('times', 'B', 20);
                $pdf->Write(0, "CERTIFICA QUE:", '', 0, 'C');
                $pdf->Ln();                  
                $pdf->SetFont('times', '', 12);
                $val = new ValoresToLetras($filaPersona['salario']);
                
                $nombreTotal = sprintf("%s%s%s%s", 
                            !empty($filaPersona['primerApellido'])? $filaPersona['primerApellido']." ": '',
                            !empty($filaPersona['segundoApellido'])? $filaPersona['segundoApellido']." ": '',
                            !empty($filaPersona['primerNombre'])? $filaPersona['primerNombre']." ": '',
                            !empty($filaPersona['segundoNombre'])? $filaPersona['segundoNombre']." ": ''
                        );                                
                list($anio, $mes, $dia) = explode("-", $filaPersona['fechaIngreso']);
                $txt = trim($nombreTotal)." identificado con tipo y numero de documento {$filaPersona['tipoDocumento']} {$filaPersona['numeroDocumento']} labora en esta compañia desde {$dia} de ".appMesNombre($mes)." de {$anio} desempeñando el cargo de {$filaPersona['nombreCargo']} devengando una compensación total de ".$val->getNumberText()." PESOS M/CTE (".appFormatoNumero($filaPersona['salario']).").";
                $pdf->Write(0, $txt, '', 0, 'J');                
                $pdf->Ln(20);
                $pdf->Write(0, "El tipo de contrato es {$filaPersona['nombreTipoContrato']}");
                $pdf->Ln(20);
                $pdf->Write(0, "La presente se expide a solicitud del interesado el ".date("d")." de ".appMesNombre(date("m"))." de ".date("Y")." en la ciudad de bogotá, con destino ".$post['dirigido']);
                $pdf->Ln(50);
                $pdf->Write(0, "Persona que firma");                
                $pdf->Ln();
                $pdf->Write(0, "Depto. Recursoso Humanos");                                                
                $ruta = "tmp/DOCCL.pdf";                
                $pdf->Output($ruta, 'F');
                
                $outDto->pdfPath = $ruta; 
                                
            }
        }
        $this->view->outDto = $outDto;
    }


}



