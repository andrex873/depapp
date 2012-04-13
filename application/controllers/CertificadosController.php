<?php

class CertificadosController extends Zend_Controller_Action
{

    private $mensajes    = array();

    public function postDispatch() {
        $this->view->mensajes = $this->mensajes;
        parent::postDispatch();
    }

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
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'S', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->mensajes[] = array('status' => 'S', 'msg' => 'El usuario no existe');
                $outDto->existe = false;                
            }else{                 
                $outDto->existe = true;                
                $outDto->filaPersona = $filaPersona;                                                
                
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                
                $pdf->SetProtection(array('modify','copy'));
                $pdf->SetCreator('Incolsoft');
                $pdf->SetAuthor('Incolsoft');
                $pdf->SetTitle('Certificación laboral');
                $pdf->SetSubject('Certificación laboral');
                $pdf->SetKeywords('Incolsoft, PDF, certificación');
                
                //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                                
                $pdf->SetMargins(40, 40, 40);
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);                
                                                
                $pdf->AddPage();                
                $pdf->Image("img/incolsoft_blancol.jpg");                
                $pdf->Ln(40);
                                                
                $pdf->SetFont('times', 'B', 20);
                $pdf->Write(0, "CERTIFICA QUE:", '', 0, 'C');
                $pdf->Ln();                  
                $pdf->SetFont('times', '', 12);
                $valorEnLetras = ValoresToLetras::convertirNumero($filaPersona['salario']);
                
                $nombreTotal = sprintf("%s%s%s%s", 
                            !empty($filaPersona['primerApellido'])? $filaPersona['primerApellido']." ": '',
                            !empty($filaPersona['segundoApellido'])? $filaPersona['segundoApellido']." ": '',
                            !empty($filaPersona['primerNombre'])? $filaPersona['primerNombre']." ": '',
                            !empty($filaPersona['segundoNombre'])? $filaPersona['segundoNombre']." ": ''
                        );                                
                list($anio, $mes, $dia) = explode("-", $filaPersona['fechaIngreso']);
                $txt = trim($nombreTotal)." identificado con tipo y numero de documento {$filaPersona['tipoDocumento']} {$filaPersona['numeroDocumento']} labora en esta compañia desde {$dia} de ".fnMesNombre($mes)." de {$anio} desempeñando el cargo de {$filaPersona['nombreCargo']} devengando una compensación total de ".$valorEnLetras." PESOS M/CTE (".fnFormatoNumero($filaPersona['salario']).").";
                $pdf->Write(0, $txt, '', 0, 'J');                
                $pdf->Ln(20);
                $pdf->Write(0, "El tipo de contrato es {$filaPersona['nombreTipoContrato']}");
                $pdf->Ln(20);
                list($anio, $mes, $dia) = explode("-", date("Y-m-d"));
                $pdf->Write(0, "La presente se expide a solicitud del interesado el {$dia} de ".fnMesNombre($mes)." de {$anio} en la ciudad de bogotá, con destino ".$post['dirigido']);
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

