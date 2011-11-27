<?php
/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginPhamlp extends Plugin {

    protected $aInherits = array(
        'module' => array(
            'ModuleViewer' => 'PluginPhamlp_ModuleViewer',
        ),
    );

    public function Activate() {
        return true;
    }

    public function Init() {

    }
}
?>
