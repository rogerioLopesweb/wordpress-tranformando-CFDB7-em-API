<?php
/*
Plugin Name: ROGER  API Formulário leads Form 7 com o plugin CFDB7
Description: Api customizada para captação de leads na base CFDB7, para popular sistema externo de BI
Version: 1.0
Author:  TECH LEAD - Rogério Lopes
Author URI: https://www.linkedin.com/in/rogerio-tech-lead/
License: GPL2
*/

use App\API\FormLeads;
require_once __DIR__ . '/vendor/autoload.php';

FormLeads::start();

?>