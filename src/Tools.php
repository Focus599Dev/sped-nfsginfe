<?php 

namespace NFePHP\NFSe\GINFE;

/**
 * @category   NFePHP
 * @package    NFePHP\NFSe\GINFE
 * @copyright  Copyright (c) 2008-2019
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Marlon O. Barbosa <marlon.academi at gmail dot com>
 * @link       https://github.com/Focus599Dev/sped-nfsginfe for the canonical source repository
 */

use NFePHP\NFSe\GINFE\Common\Tools as ToolsBase;
use NFePHP\Common\Strings;
use NFePHP\NFSe\GINFE\Common\Signer;
use DOMDocument;
use NFePHP\Common\DOMImproved as Dom;


class Tools extends ToolsBase {

	public function enviaRPS($xml){

		if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }
        //remove all invalid strings
        $xml = Strings::clearXmlString($xml);

        $servico = 'RecepcionarLoteRpsV3';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'EnviarLoteRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;
        
        $this->isValid($this->versao, $request, 'servico_enviar_lote_rps_envio');

        $parameters = ['RecepcionarLoteRps' => $request];

        $request = $this->MakeEnvelope($servico, $request);
        
        $this->lastResponse = $this->sendRequest($request, $parameters);
        
        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

	}

    public function consultaLoteRPS($prot, \stdClass $prestador){

        $servico = 'ConsultarLoteRpsV3';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $namespaces = array(
            'xmlns:p="http://www.ginfes.com.br/servico_consultar_lote_rps_envio_v03.xsd"',
            'xmlns:tipos="http://www.ginfes.com.br/tipos_v03.xsd"',
            'xmlns="http://www.w3.org/2000/09/xmldsig#"'
        );

        $xml = '<p:ConsultarLoteRpsEnvio Id="' . str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT) . '" ';

            $xml .= implode(' ', $namespaces) . '>';

            $xml .= '<p:Prestador>';

                $xml .= '<tipos:Cnpj>' . $prestador->cnpj . '</tipos:Cnpj>';
                
                $xml .= '<tipos:InscricaoMunicipal>' . $prestador->inscricaoMunicipal . '</tipos:InscricaoMunicipal>';
                
            $xml .= '</p:Prestador>';

            $xml .= '<p:Protocolo>' . $prot . '</p:Protocolo>';

        $xml .= '</p:ConsultarLoteRpsEnvio>';

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'ConsultarLoteRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;

        $this->isValid($this->versao, $request, 'servico_consultar_lote_rps_envio');

        $parameters = ['ConsultarLoteRpsEnvio' => $request];

        $request = $this->MakeEnvelope($servico, $request);

        $this->lastResponse = $this->sendRequest($request, $parameters);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

    }

    public function consultaSituacaoLoteRPS($prot, \stdClass $prestador){

        $servico = 'ConsultarSituacaoLoteRpsV3';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $namespaces = array(
            'xmlns:p="http://www.ginfes.com.br/servico_consultar_situacao_lote_rps_envio_v03.xsd"',
            'xmlns:tipos="http://www.ginfes.com.br/tipos_v03.xsd"',
            'xmlns="http://www.w3.org/2000/09/xmldsig#"'
        );

        $xml = '<p:ConsultarSituacaoLoteRpsEnvio Id="' . str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT) . '" ';

            $xml .= implode(' ', $namespaces) . '>';

            $xml .= '<p:Prestador>';

                $xml .= '<tipos:Cnpj>' . $prestador->cnpj . '</tipos:Cnpj>';
                
                $xml .= '<tipos:InscricaoMunicipal>' . $prestador->inscricaoMunicipal . '</tipos:InscricaoMunicipal>';
                
            $xml .= '</p:Prestador>';

            $xml .= '<p:Protocolo>' . $prot . '</p:Protocolo>';

        $xml .= '</p:ConsultarSituacaoLoteRpsEnvio>';

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'ConsultarSituacaoLoteRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;

        $this->isValid($this->versao, $request, 'servico_consultar_situacao_lote_rps_envio');

        $parameters = ['ConsultarSituacaoLoteRpsEnvio' => $request];

        $request = $this->MakeEnvelope($servico, $request);

        $this->lastResponse = $this->sendRequest($request, $parameters);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

    }
    
    public function ConsultarNfsePorRps(\stdClass $indenRPS , \stdClass $prestador){

        $servico = 'ConsultarNfsePorRpsV3';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $namespaces = array(
            'xmlns:p="http://www.ginfes.com.br/servico_consultar_nfse_rps_envio_v03.xsd"',
            'xmlns:tipos="http://www.ginfes.com.br/tipos_v03.xsd"',
            'xmlns="http://www.w3.org/2000/09/xmldsig#"'
        );

        $xml = '<p:ConsultarNfseRpsEnvio ';

            $xml .= implode(' ', $namespaces) . '>';

            $xml .= '<p:IdentificacaoRps>';

                $xml .= '<tipos:Numero>' . $indenRPS->Numero . '</tipos:Numero>';
                
                $xml .= '<tipos:Serie>' . $indenRPS->Serie . '</tipos:Serie>';
                
                $xml .= '<tipos:Tipo>' . $indenRPS->Tipo . '</tipos:Tipo>';

            $xml .= '</p:IdentificacaoRps>';

            $xml .= '<p:Prestador>';

                $xml .= '<tipos:Cnpj>' . $prestador->cnpj . '</tipos:Cnpj>';
                
                $xml .= '<tipos:InscricaoMunicipal>' . $prestador->inscricaoMunicipal . '</tipos:InscricaoMunicipal>';
                
            $xml .= '</p:Prestador>';

        $xml .= '</p:ConsultarNfseRpsEnvio>';

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'ConsultarNfseRpsEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;

        $this->isValid($this->versao, $request, 'servico_consultar_nfse_rps_envio');

        $parameters = ['ConsultarNfseRpsEnvio' => $request];

        $request = $this->MakeEnvelope($servico, $request);

        $this->lastResponse = $this->sendRequest($request, $parameters);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

    }

    public function ConsultarNfse($NumeroNfse , \stdClass $prestador){

        $servico = 'ConsultarNfseV3';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $namespaces = array(
            'xmlns:p="http://www.ginfes.com.br/servico_consultar_nfse_envio_v03.xsd"',
            'xmlns:tipos="http://www.ginfes.com.br/tipos_v03.xsd"',
            'xmlns="http://www.w3.org/2000/09/xmldsig#"'
        );

        $xml = '<p:ConsultarNfseEnvio ';

            $xml .= implode(' ', $namespaces) . '>';

            $xml .= '<p:Prestador>';

                $xml .= '<tipos:Cnpj>' . $prestador->cnpj . '</tipos:Cnpj>';
                
                $xml .= '<tipos:InscricaoMunicipal>' . $prestador->inscricaoMunicipal . '</tipos:InscricaoMunicipal>';
                
            $xml .= '</p:Prestador>';

            $xml .= '<p:NumeroNfse>' . $NumeroNfse . '</p:NumeroNfse>';

        $xml .= '</p:ConsultarNfseEnvio>';

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'ConsultarNfseEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;


        $this->isValid($this->versao, $request, 'servico_consultar_nfse_envio');

        $parameters = ['ConsultarNfseEnvio' => $request];

        $request = $this->MakeEnvelope($servico, $request);

        $this->lastResponse = $this->sendRequest($request, $parameters);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

    }

    public function CancelaNfse($pedCan){

        $servico = 'CancelarNfse';

        $this->servico(
            $servico,
            $this->config->municipio,
            $this->tpAmb
        );

        $namespaces = array(
            'xmlns:p="http://www.ginfes.com.br/servico_cancelar_nfse_envio"',
            'xmlns:tipos="http://www.ginfes.com.br/tipos"',
            'xmlns="http://www.w3.org/2000/09/xmldsig#"'
        );

        // XML v3 
        // $xml = '<p:CancelarNfseEnvio ';

        //     $xml .= implode(' ', $namespaces) . '>';

        //     $xml .= '<Pedido xmlns="">';

        //         $xml .= '<tipos:InfPedidoCancelamento Id="' . $pedCan->Numero . '">';

        //             $xml .= '<tipos:IdentificacaoNfse>';

        //                 $xml .= '<tipos:Numero>' . $pedCan->Numero . '</tipos:Numero>';
                        
        //                 $xml .= '<tipos:Cnpj>' . $pedCan->cnpj . '</tipos:Cnpj>';

        //                 $xml .= '<tipos:InscricaoMunicipal>' . $pedCan->InscricaoMunicipal . '</tipos:InscricaoMunicipal>';

        //                 $xml .= '<tipos:CodigoMunicipio>' . $pedCan->CodigoMunicipio . '</tipos:CodigoMunicipio>';

        //             $xml .= '</tipos:IdentificacaoNfse>';

        //             $xml .= '<tipos:CodigoCancelamento>' . $pedCan->CodigoCancelamento . '</tipos:CodigoCancelamento>';

        //         $xml .= '</tipos:InfPedidoCancelamento>';

        //     $xml .= '</Pedido>';

        // $xml .= '</p:CancelarNfseEnvio>';
        
        // XML v2
        $this->version('2.0.2');

        $xml = '<p:CancelarNfseEnvio ';

            $xml .= implode(' ', $namespaces) . '>';

           $xml .= '<p:Prestador>';

                $xml .= '<tipos:Cnpj>' . $pedCan->cnpj . '</tipos:Cnpj>';
                
                $xml .= '<tipos:InscricaoMunicipal>' . $pedCan->InscricaoMunicipal . '</tipos:InscricaoMunicipal>';
                
            $xml .= '</p:Prestador>';

            $xml .= '<p:NumeroNfse>' . $pedCan->Numero . '</p:NumeroNfse>';

        $xml .= '</p:CancelarNfseEnvio>';

        $request = Signer::sign(
            $this->certificate,
            $xml,
            'CancelarNfseEnvio',
            'Id',
            $this->algorithm,
            $this->canonical
        );

        $this->lastRequest = $request;

        $this->isValid($this->versao, $request, 'servico_cancelar_nfse_envio');

        $parameters = ['CancelarNfseEnvio' => $request];

        $request = $this->MakeEnvelope($servico, $request);

        $this->lastResponse = $this->sendRequest($request, $parameters);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return (String) $auxResp->return[0];

    }

    public function generateUrlPDFNfse($code_municipio, $CodigoVerificacao, $nnf, $cnpj_emit ){

        $municipio = array(
            '3543402' => array(
                'cname' => 'ribeiraopreto',
                'param' => 'nfs_ribeirao_preto',
            ),
            '3516200' => array(
                'cname' => 'franca',
                'param' => 'nfs_franca',
            )
        );

        $urls = array(
            '1' => '.ginfe.com.br',
            '2' => '.ginfesh.com.br'
        );

        $url = '';

        if (isset( $municipio[$code_municipio] )){

            if (!isset($urls[$this->tpAmb]))
                throw new \Exception("Ambiente não localizado");

            $url = 'http://' . $municipio[$code_municipio]['cname'] . $urls[$this->tpAmb] . '/report/consultarNota?__report=' . $municipio[$code_municipio]['param'] . '&cdVerificacao=' . $CodigoVerificacao . '&numNota=' . $nnf . '&cnpjPrestador=' . $cnpj_emit; 

            return $url;
        }

        throw new \Exception("Municipio não localizado");
        

    }
}                                                                                                                            

?>