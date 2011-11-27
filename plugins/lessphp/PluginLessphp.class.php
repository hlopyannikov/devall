<?php
/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginLessphp extends Plugin {

    protected $aInherits = array(
        'module' => array(
            'ModuleViewer' => 'PluginLessphp_ModuleViewer',
        ),
    );

    public function Activate() {
        return true;
    }

    public function Init() {

    }
}
?>
