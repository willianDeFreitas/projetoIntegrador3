<?php
class TrataDecimais {

    public function convertePontoEmVirgula($valor, $trataCasaPosVirgula){
        $ponto = ".";
        $procuraPonto = strpos($valor, $ponto);

        if($procuraPonto === false ){
            $valorFinal = $valor;
        }else{
            $valorFinal = str_replace(".",",",$valor);
        }

        if($trataCasaPosVirgula){
            $valorFinal = self::trataCasaPosVirgula($valorFinal);
        }

        return $valorFinal;
    }

    public function converteVirgulaEmPonto($valor){
        $virgula = ",";
        $procuraVirgula = strpos($valor, $virgula);
        if($procuraVirgula === false ){
            $valorFinal = $valor;
        }else{
            $valorFinal = str_replace(",",".",$valor);
        }

        return $valorFinal;
    }

    public function trataCasaPosVirgula($valor){
        $virgula = strpos($valor,",");
        $qtdInt = substr($valor,0,$virgula);
        $qtdDec = substr($valor,$virgula,3);

        $qtdFim = $qtdInt.$qtdDec;

        return $qtdFim;
    }

    public function trataCasaPosPonto($valor){
        $teste = strpos($valor,".");
        $qtdInt = substr($valor,0,$teste);
        $qtdDec = substr($valor,$teste,3);

        $qtdFim = $qtdInt.$qtdDec;

        return $qtdFim;
    }

    public function trataZeroPosVirgula($valor){
        $procuraVirgula = strpos($valor,",");
        $procuraPonto = strpos($valor,".");
        if($procuraVirgula === false && $procuraPonto === false){
            $valorFinal = $valor.",00";
        }else if ($procuraVirgula === false && !$procuraPonto === false){
            $valorFinal = self::convertePontoEmVirgula($valor, true);
        }else{
            $valorFinal = $valor;
        }

        return $valorFinal;
    }

}
?>