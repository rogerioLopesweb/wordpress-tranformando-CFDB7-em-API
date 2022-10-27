<?php
namespace App\API;
class FormLeads {
   /*
   // ROGER_API_TOKEN é preciso add no wp_config.php 
   // define('ROGER_API_TOKEN', 'A74A86B51168F25A9872F9F770991A');
   */
    public static function start()
    {
      
        add_action(
            'rest_api_init',
            function () {
                register_rest_route(
                    'api/formleads',
                    '/todos',
                    array(
                    'methods' => 'GET',
                    'callback' => "App\API\FormLeads::listaTodos",
                    )
                );
            }
        );

        add_action(
            'rest_api_init',
            function () {
                register_rest_route(
                    'api/formleads',
                    '/ultimos',
                    array(
                    'methods' => 'GET',
                    'callback' => "App\API\FormLeads::listaUltimos",
                    )
                );
            }
        );


        add_action(
            'rest_api_init',
            function () {
                register_rest_route(
                    'api/formleads',
                    '/hoje',
                    array(
                    'methods' => 'GET',
                    'callback' => "App\API\FormLeads::listaHoje",
                    )
                );
            }
        );
    }

    public static function listaTodos($data)
    {
       $token = $data->get_param( 'token' ) ? : "";
       
       if($token != DREAMONE_API_TOKEN){
         $error =array ( 'codigo' => '001', 'mensagem' => 'Acesso negado!');
         wp_send_json_error( $error );
       }
      

       
       global $wpdb;
       $query = 'SELECT ';
       $query .= 'b.data_id AS Id ';
       $query .= ', a.ID AS formId ';
       $query .= ', a.post_title AS formulario ';
       $query .= ', MAX(Case When b.name="nome" THEN b.value END ) AS nome ' ;
       $query .= ', MAX(Case When b.name="email" THEN b.value END ) AS email ';
       $query .= ', MAX(Case When b.name="empresa" THEN b.value END ) AS empresa ';
       $query .= ', MAX(Case When b.name="telefone" THEN b.value END ) AS telefone ';
       $query .= ', MAX(Case When b.name="cidade" THEN b.value END ) AS cidade ';
       $query .= ', MAX(Case When b.name="estado" THEN b.value END ) AS estado ';
       $query .= ', MAX(Case When b.name="pais" THEN b.value END ) AS pais ';
       $query .= ', MAX(Case When b.name="submit_time"THEN b.value END ) AS data_hora ';
       $query .= ', MAX(Case When b.name="submit_ip" THEN b.value END ) AS ip ';
       $query .= ', MAX(Case When b.name="termospolitica" THEN b.value END ) AS termospolitica ';
       $query .= ', MAX(Case When b.name="mensagem" THEN b.value END ) AS mensagem ';
       $query .= ', MAX(Case When b.name="segmento" THEN b.value END ) AS segmento ';
       $query .= ', MAX(Case When b.name="interesse" THEN b.value END ) AS interesse ';
       $query .= ', MAX(Case When b.name="file-111" THEN b.value END ) AS filePDF ';
       $query .= ', MAX(Case When b.name="produto" THEN b.value END ) AS produto ';
       $query .= ', MAX(Case When b.name="toneladas" THEN b.value END ) AS toneladas ';
       $query .= ', MAX(Case When b.name="cultivos" THEN b.value END ) AS cultivos ';
       $query .= ', MAX(Case When b.name="cultivosoutros" THEN b.value END ) AS cultivosoutros ';
       $query .= ', MAX(Case When b.name="toneladassolo" THEN b.value END ) AS toneladassolo ';
       $query .= ', MAX(Case When b.name="cultivossolo" THEN b.value END ) AS cultivossolo ';
       $query .= ', MAX(Case When b.name="cultivossolooutros" THEN b.value END ) AS cultivossolooutros ';
       $query .= ', MAX(Case When b.name="tratamentos" THEN b.value END ) AS tratamentos ';
       $query .= ', MAX(Case When b.name="tratamentosoutros" THEN b.value END ) AS tratamentosoutros ';
       $query .= ', MAX(Case When b.name="areatratada" THEN b.value END ) AS areatratada ';
       $query .= 'FROM '. $wpdb->prefix . 'posts a ';  
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata_entry b ON a.ID = b.cf7_id ';
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata c ON c.id = b.data_id ';
       $query .= "WHERE a.post_type = 'wpcf7_contact_form' ";
       $query .= 'GROUP BY b.data_id ';
       $query .= 'ORDER BY b.data_id asc ';
       $result = $wpdb->get_results($query);

       /*$sqlQ = array('SQL' =>$query) ;  
       wp_send_json($sqlQ, 200);
       exit;*/
     
      $dados["lista"] = array();
      $lista[] = array();
      if ($result) {
            foreach($result as $row) {
               
                $lista = array(
                    'id' => $row->Id,
                    'formid' => $row->formId,
                    'form' => $row->formulario,
                    'empresa' => $row->empresa,
                    'nome' => $row->nome,
                    'email' => $row->email,
                    'telefone' => $row->telefone,
                    'cidade' => $row->cidade,
                    'estado' => $row->estado,
                    'pais' => $row->pais,
                    'data_hora' => $row->data_hora,
                    'ip' => $row->ip,
                    'termospolitica' => $row->termospolitica,
                    'mensagem' => $row->mensagem,
                    'segmento' => $row->segmento,
                    'interesse' => $row->interesse,
                    'filePDF' => $row->filePDF,
                    'produto' => $row->produto,
                    'toneladas' => $row->toneladas,
                    'cultivos' => $row->cultivos,
                    'cultivosoutros' => $row->cultivosoutros,
                    'toneladassolo' => $row->toneladassolo,
                    'cultivossolo' => $row->cultivossolo,
                    'cultivossolooutros' => $row->cultivossolooutros,
                    'tratamentos' => $row->tratamentos,
                    'tratamentosoutros' => $row->tratamentosoutros,
                    'areatratada' =>$row->areatratada
                );
                array_push($dados["lista"], $lista);
               
            }
        } 
        
        wp_send_json($dados, 200);
    }


    public static function listaUltimos($data)
    {
       $token = $data->get_param( 'token' ) ? : "";
       $qtd = $data->get_param( 'qtd' ) ? : 25;
       
       if($token != DREAMONE_API_TOKEN){
         $error =array ( 'codigo' => '001', 'mensagem' => 'Acesso negado!');
         wp_send_json_error( $error );
       }
      

       global $wpdb;
       $query = 'SELECT ';
       $query .= 'b.data_id AS Id ';
       $query .= ', a.ID AS formId ';
       $query .= ', a.post_title AS formulario ';
       $query .= ', MAX(Case When b.name="nome" THEN b.value END ) AS nome ' ;
       $query .= ', MAX(Case When b.name="email" THEN b.value END ) AS email ';
       $query .= ', MAX(Case When b.name="empresa" THEN b.value END ) AS empresa ';
       $query .= ', MAX(Case When b.name="telefone" THEN b.value END ) AS telefone ';
       $query .= ', MAX(Case When b.name="cidade" THEN b.value END ) AS cidade ';
       $query .= ', MAX(Case When b.name="estado" THEN b.value END ) AS estado ';
       $query .= ', MAX(Case When b.name="pais" THEN b.value END ) AS pais ';
       $query .= ', MAX(Case When b.name="submit_time"THEN b.value END ) AS data_hora ';
       $query .= ', MAX(Case When b.name="submit_ip" THEN b.value END ) AS ip ';
       $query .= ', MAX(Case When b.name="termospolitica" THEN b.value END ) AS termospolitica ';
       $query .= ', MAX(Case When b.name="mensagem" THEN b.value END ) AS mensagem ';
       $query .= ', MAX(Case When b.name="segmento" THEN b.value END ) AS segmento ';
       $query .= ', MAX(Case When b.name="interesse" THEN b.value END ) AS interesse ';
       $query .= ', MAX(Case When b.name="file-111" THEN b.value END ) AS filePDF ';
       $query .= ', MAX(Case When b.name="produto" THEN b.value END ) AS produto ';
       $query .= ', MAX(Case When b.name="toneladas" THEN b.value END ) AS toneladas ';
       $query .= ', MAX(Case When b.name="cultivos" THEN b.value END ) AS cultivos ';
       $query .= ', MAX(Case When b.name="cultivosoutros" THEN b.value END ) AS cultivosoutros ';
       $query .= ', MAX(Case When b.name="toneladassolo" THEN b.value END ) AS toneladassolo ';
       $query .= ', MAX(Case When b.name="cultivossolo" THEN b.value END ) AS cultivossolo ';
       $query .= ', MAX(Case When b.name="cultivossolooutros" THEN b.value END ) AS cultivossolooutros ';
       $query .= ', MAX(Case When b.name="tratamentos" THEN b.value END ) AS tratamentos ';
       $query .= ', MAX(Case When b.name="tratamentosoutros" THEN b.value END ) AS tratamentosoutros ';
       $query .= ', MAX(Case When b.name="areatratada" THEN b.value END ) AS areatratada ';
       $query .= 'FROM '. $wpdb->prefix . 'posts a ';  
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata_entry b ON a.ID = b.cf7_id ';
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata c ON c.id = b.data_id ';
       $query .= "WHERE a.post_type = 'wpcf7_contact_form' ";
       $query .= 'GROUP BY b.data_id ';
       $query .= 'ORDER BY b.data_id DESC ';
       $query .= 'LIMIT ' . $qtd;
       $result = $wpdb->get_results($query);

       /*$sqlQ = array('SQL' =>$query) ;  
       wp_send_json($sqlQ, 200);
       exit;*/
     
      $dados["lista"] = array();
      $lista[] = array();
      if ($result) {
            foreach($result as $row) {
                $lista = array(
                    'id' => $row->Id,
                    'formid' => $row->formId,
                    'form' => $row->formulario,
                    'empresa' => $row->empresa,
                    'nome' => $row->nome,
                    'email' => $row->email,
                    'telefone' => $row->telefone,
                    'cidade' => $row->cidade,
                    'estado' => $row->estado,
                    'pais' => $row->pais,
                    'data_hora' => $row->data_hora,
                    'ip' => $row->ip,
                    'termospolitica' => $row->termospolitica,
                    'mensagem' => $row->mensagem,
                    'segmento' => $row->segmento,
                    'interesse' => $row->interesse,
                    'filePDF' => $row->filePDF,
                    'produto' => $row->produto,
                    'toneladas' => $row->toneladas,
                    'cultivos' => $row->cultivos,
                    'cultivosoutros' => $row->cultivosoutros,
                    'toneladassolo' => $row->toneladassolo,
                    'cultivossolo' => $row->cultivossolo,
                    'cultivossolooutros' => $row->cultivossolooutros,
                    'tratamentos' => $row->tratamentos,
                    'tratamentosoutros' => $row->tratamentosoutros,
                    'areatratada' =>$row->areatratada
                );
                array_push($dados["lista"], $lista);
               
            }
        } 
        
        wp_send_json($dados, 200);
    }

    public static function listaHoje($data)
    {
       $token = $data->get_param( 'token' ) ? : "";
       $qtd = $data->get_param( 'qtd' ) ? : 25;
       
       if($token != DREAMONE_API_TOKEN){
         $error =array ( 'codigo' => '001', 'mensagem' => 'Acesso negado!');
         wp_send_json_error( $error );
       }
      

       global $wpdb;
       $query = 'SELECT ';
       $query .= 'b.data_id AS Id ';
       $query .= ', a.ID AS formId ';
       $query .= ', a.post_title AS formulario ';
       $query .= ', MAX(Case When b.name="nome" THEN b.value END ) AS nome ' ;
       $query .= ', MAX(Case When b.name="email" THEN b.value END ) AS email ';
       $query .= ', MAX(Case When b.name="empresa" THEN b.value END ) AS empresa ';
       $query .= ', MAX(Case When b.name="telefone" THEN b.value END ) AS telefone ';
       $query .= ', MAX(Case When b.name="cidade" THEN b.value END ) AS cidade ';
       $query .= ', MAX(Case When b.name="estado" THEN b.value END ) AS estado ';
       $query .= ', MAX(Case When b.name="pais" THEN b.value END ) AS pais ';
       $query .= ', MAX(Case When b.name="submit_time"THEN b.value END ) AS data_hora ';
       $query .= ', MAX(Case When b.name="submit_ip" THEN b.value END ) AS ip ';
       $query .= ', MAX(Case When b.name="termospolitica" THEN b.value END ) AS termospolitica ';
       $query .= ', MAX(Case When b.name="mensagem" THEN b.value END ) AS mensagem ';
       $query .= ', MAX(Case When b.name="segmento" THEN b.value END ) AS segmento ';
       $query .= ', MAX(Case When b.name="interesse" THEN b.value END ) AS interesse ';
       $query .= ', MAX(Case When b.name="file-111" THEN b.value END ) AS filePDF ';
       $query .= ', MAX(Case When b.name="produto" THEN b.value END ) AS produto ';
       $query .= ', MAX(Case When b.name="toneladas" THEN b.value END ) AS toneladas ';
       $query .= ', MAX(Case When b.name="cultivos" THEN b.value END ) AS cultivos ';
       $query .= ', MAX(Case When b.name="cultivosoutros" THEN b.value END ) AS cultivosoutros ';
       $query .= ', MAX(Case When b.name="toneladassolo" THEN b.value END ) AS toneladassolo ';
       $query .= ', MAX(Case When b.name="cultivossolo" THEN b.value END ) AS cultivossolo ';
       $query .= ', MAX(Case When b.name="cultivossolooutros" THEN b.value END ) AS cultivossolooutros ';
       $query .= ', MAX(Case When b.name="tratamentos" THEN b.value END ) AS tratamentos ';
       $query .= ', MAX(Case When b.name="tratamentosoutros" THEN b.value END ) AS tratamentosoutros ';
       $query .= ', MAX(Case When b.name="areatratada" THEN b.value END ) AS areatratada ';
       $query .= 'FROM '. $wpdb->prefix . 'posts a ';  
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata_entry b ON a.ID = b.cf7_id ';
       $query .= 'INNER JOIN ' . $wpdb->prefix . 'cf7_vdata c ON c.id = b.data_id ';
       $query .= "WHERE a.post_type = 'wpcf7_contact_form' ";
       $query .= 'AND  day(c.created) = DAY(NOW()) ';
       $query .= 'AND  month(c.created) = month(NOW()) ';
       $query .= 'AND  year(c.created) = year(NOW()) ';
       $query .= 'GROUP BY b.data_id ';
       $query .= 'ORDER BY b.data_id DESC ';
       $query .= 'LIMIT ' . $qtd;
       $result = $wpdb->get_results($query);

       /*$sqlQ = array('SQL' =>$query) ;  
       wp_send_json($sqlQ, 200);
       exit;*/
     
      $dados["lista"] = array();
      $lista[] = array();
      if ($result) {
            foreach($result as $row) {
                $lista = array(
                    'id' => $row->Id,
                    'formid' => $row->formId,
                    'form' => $row->formulario,
                    'empresa' => $row->empresa,
                    'nome' => $row->nome,
                    'email' => $row->email,
                    'telefone' => $row->telefone,
                    'cidade' => $row->cidade,
                    'estado' => $row->estado,
                    'pais' => $row->pais,
                    'data_hora' => $row->data_hora,
                    'ip' => $row->ip,
                    'termospolitica' => $row->termospolitica,
                    'mensagem' => $row->mensagem,
                    'segmento' => $row->segmento,
                    'interesse' => $row->interesse,
                    'filePDF' => $row->filePDF,
                    'produto' => $row->produto,
                    'toneladas' => $row->toneladas,
                    'cultivos' => $row->cultivos,
                    'cultivosoutros' => $row->cultivosoutros,
                    'toneladassolo' => $row->toneladassolo,
                    'cultivossolo' => $row->cultivossolo,
                    'cultivossolooutros' => $row->cultivossolooutros,
                    'tratamentos' => $row->tratamentos,
                    'tratamentosoutros' => $row->tratamentosoutros,
                    'areatratada' =>$row->areatratada
                );
                array_push($dados["lista"], $lista);
               
            }
        } 
        wp_send_json($dados, 200);
    }
}
