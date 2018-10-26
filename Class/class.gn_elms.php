<?php
    
    
    class gn_elms{
        
        function __construct(){
            require_once("header.php");
            makeHeather();
            $this->tabindex = 0 ;
        }
        
        
        function formBegin($action, $tabela, $operacao){
            return "<form class='span12' name='formulario' method='POST' action='$action?tabela=$tabela&Operacao=$operacao'>";
        }
        
        function formEnd(){
            return "</form>";
        }
        
        
        function botoesRodape($labelAzul='', $labelVermelho='', $centraliza = ''){
            if($centraliza != true){
                $cache="
                <div class='container'>
                <div class='col-xs-12 col-md-12'>"; 
                if ($labelAzul!==''){
                    $cache.="<button type='submit' id='btnCadastrar' onclick='' class='btn btn-primary  pull-right'style='margin:5px;' >$labelAzul</button>";
                }
                if ($labelVermelho!==''){
                    $cache.="<button type='button' id='btnCancelar' class='btn btn-danger pull-right' style='margin:5px;'onclick='cancelar()'>$labelVermelho</button>";
                }
                $cache.="
                </div>
                </div>
                ";
            }
            else {
                $cache="
                <div class='container'>
                <div  class=' col-md-offset-5 col-xs-4 col-md-6'>"; 
                if ($labelAzul!==''){
                    $cache.="<button type='submit' id='btnCadastrar' class='btn btn-primary btn-md  '  style='margin:5px'>$labelAzul</button>";
                }
                if ($labelVermelho!==''){
                    $cache.="<button type='button' id='btnCancelar' class='btn btn-danger  btn-md'   onclick='cancelar()'>$labelVermelho</button>";
                }
                $cache.="
                </div>
                </div>
                ";
            }
            
            $cache .="<script> 
                        function cancelar(){ window.location.href='./menuPrincipal.php';}
                     </script> ";
            
            return $cache;
        }
        


        function selectDb ($attr)        {

                require_once('class.gn_tabela.php');
                
                // chama o metodo estatico
                // echo ($attr['SQL']);
                $tabelaBanco = gn_tabela::executarNoBanco($attr['SQL']);
                
                
                $attr['options']=array();
                foreach ($tabelaBanco as $linha) {
                    $key   = $linha[$attr["SELECT_VALUE"]] ; 
                    $value = $linha[$attr["SELECT_NAME"]] ; 
                    $attr['options'][$key] = $value;
                }

                unset($attr['SQL']);
                unset($attr['type']);
                unset($attr["SELECT_VALUE"]);
                unset($attr["SELECT_VALUE"]);
                
                return $attr ; 

        }

        function select ($attr=array()){
            
            if (isset($attr['type']) && $attr['type'] == 'db'){
                $attr = $this->selectDb($attr);
            }

            $cache = '';

            foreach($attr['options'] as $key => $value ){
                $cache.=$this->gnElm('option', array('value'=>$key, 'innerHTML'=>$value));
            }

            unset($attr['options']);

            $cache = $this->gnElm('select', $attr, true, $cache);
            
            $cache = "
                <div class='col-sn-12 col-md-6'>
                    <label for='$attr[banco]'>$attr[label]: </label>
                    $cache
                </div>";
            return $cache;
        }

        function input ($attr=array()){

            $imput = "<div class='col-sn-12 col-md-6'>
                <label for='{$attr['banco']}'>{$attr['label']}: </label>";
                $imput.= $this->gnElm('input', $attr);
            $imput.= "</div>";
            return $imput;
        }

        
        function gnElm($tagName = '', $attrs = array(), $closeTag=true, $innerHTML='')
        {
            $cache = "";
            // $innerHTML='';
            
            if ( array_key_exists('innerHTML', $attrs) ) {
                $innerHTML = $attrs['innerHTML'] ; 
                unset($attrs['innerHTML']);
            }
            
            // $attrs['tabindex'] = $this->tabIndex;
            //$this->tabIndex++;
            
            
            $HTML_attrs = $this->gn_attr($attrs);
            
            $cache.= "<$tagName $HTML_attrs>";
                $cache.= "$innerHTML";
            $cache.= $closeTag ? "</$tagName>" : "" ;
            
            return $cache;
            
        }
        
        
        
        function getStyle($style)
        {
            if ( !is_array($style) ) { 
                return $style;
            } else {
                $str_style="";
                foreach ($style as $key => $val) {
                    $key = trim($key) ; 
                    $val = trim($val) ; 
                    $val = str_replace(';', '', $val);
                    $str_style.= "$key:$val;";
                }
                return $str_style;
            }
        }
        
        
        
        
        function gn_attr($attrs=array())
        {
            if ( !array_key_exists('id', $attrs)   && array_key_exists('name', $attrs) ) {
                $attrs['id'] = $attrs['name'] ; 
            }
            
            if ( !array_key_exists('name', $attrs) && array_key_exists('id'  , $attrs) ) {
                $attrs['name'] = $attrs['id'] ; 
            }
            
            if ( array_key_exists('style', $attrs)){
                $attrs['style'] = $this->getStyle( $attrs['style'] ) ; 
            }
            
            $_attr='';
            
            foreach($attrs as $attr => $vl) { 
                $_attr.=" $attr='$vl'";
            }
            
            return $_attr;
            
        }
        
        
        
    }
    
    
    