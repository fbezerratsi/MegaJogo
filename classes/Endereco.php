<?php

    class Endereco {
        private $id;
        private $rua;
        private $numero;
        private $bairro;
        private $cidade;
        private $estado;
        private $cep;
        
        public function Endereco($id, $rua, $numero, $bairro, $cidade, $estado, $cep) {
            $this->id = $id;
            $this->rua = $rua;
            $this->numero = $numero;
            $this->bairro = $bairro;
            $this->cidade = $cidade;
            $this->estado = $estado;
            $this->cep = $cep;
        }
        
        /**
         * Mostra todos os estados em um campo de seleção
         */
        public function mostrarEstados() {
            $estados = array (
                1 => 'AC',
                2 => 'AL',
                3 => 'AP',
                4 => 'AM',
                5 => 'BA',
                6 => 'CE',
                7 => 'DF',
                8 => 'ES',
                9 => 'GO',
                10 => 'MA',
                11 => 'MT',
                12 => 'MS',
                13 => 'MG',
                14 => 'PA',
                15 => 'PB',
                16 => 'PR',
                17 => 'PE',
                18 => 'PI',
                19 => 'RJ',
                20 => 'RN',
                21 => 'RS',
                22 => 'RO',
                23 => 'RR',
                24 => 'SC',
                25 => 'SP',
                26 => 'SE',
                27 => 'TO',
            );
            
            return $estados;
//            print '<select name=\'selEstado\'>';
//            
//            for ($index = 0; $index < count($estados); $index++) {
//                print '<option value="'.$estados[$index].'">'. $estados[$index] . '</option>';
//            }
//            
//            print '</select>';
        }

        public function getRua() {
            return $this->rua;
        }
        public function getNumero() {
            return $this->numero;
        }
        public function getBairro() {
            return $this->bairro;
        }
        public function getCidade() {
            return $this->cidade;
        }
        public function getEstado() {
            return $this->estado;
        }
        public function getCep() {
            return $this->cep;
        }
    }

?>
