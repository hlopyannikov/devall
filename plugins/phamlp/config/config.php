<?php
$config=array();

$config['sass']['use'] = true;
$config['sass']['cache'] = false;
//$config['sass']['cache_location'] = './sass-cache';
//$config['sass']['css_location'] = './css';
$config['sass']['debug_info'] = false;
//$config['sass']['filename']              = array('dirname' => '', 'basename' => '');
//$config['sass']['filename']              = '';
//$config['sass']['function_paths']      = array();
$config['sass']['template_location']     = "___path.smarty.template___/sass/";
//$config['sass']['line']                = 1;
//$config['sass']['line_numbers']        = false;
$config['sass']['style']                 = 'compressed';
$config['sass']['syntax']                = 'scss';

$config['sass']['extensions'] = array('compass' => array(
    'project_path' => "___path.static.skin___",
    'http_path' => '/',
    'css_dir' => 'css',
    'css_path' => '',
    'http_css_path' => '',
    'fonts_dir' => 'fonts',
    'fonts_path' => '',
    'http_fonts_path' => '',
    'images_dir' => 'images',
    'images_path' => '',
    'http_images_path' => '',
    'javascripts_dir' => 'javascripts',
    'javascripts_path' => '',
    'http_javascripts_path' => '',
    'relative_assets' => true,
));

return $config;
?>
