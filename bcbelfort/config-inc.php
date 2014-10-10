<?php
 
$cfg['PmaAbsoluteUri'] = 'http://www.bcbelfort.fr/phpMyAdmin/'; // ici url complete vers /phpMyAdmin/
 
/**
* Configuration serveur ici chez OVH - hebergement mutualise
**/
 
$i = 0;
$i++;
//$cfg['Servers'][$i]['host'] = 'serveur_sql'; // ici
$cfg['Servers'][$i]['host'] = '37.187.128.36'; // ici
$cfg['Servers'][$i]['port'] = '';
$cfg['Servers'][$i]['socket'] = '';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['controluser'] = '';
$cfg['Servers'][$i]['controlpass'] = '';
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'bcbelfort_wp'; // ici
$cfg['Servers'][$i]['password'] = 'UCKSDm25^Zz/LOTWJ:lu2IR9H%mD`X7r=n39lxISm?crsnzVK['; // ici
$cfg['Servers'][$i]['only_db'] = 'bcbelfort_wp'; // ici
 
?>