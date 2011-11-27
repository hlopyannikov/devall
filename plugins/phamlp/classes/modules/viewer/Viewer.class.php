<?php

require_once(Plugin::GetPath('phamlp').'classes/lib/external/PHamlP_3.2/sass/SassParser.php');

class PluginPhamlp_ModuleViewer extends PluginPhamlp_Inherit_ModuleViewer {

    /**
     * Сжимает все переданные файлы в один,
     * использует файловое кеширование
     *
     * @param  array  $aFiles
     * @param  string $sType
     * @return array
     */
    protected function Compress($aFiles,$sType) {
        $sCacheDir  = $this->sCacheDir."/".Config::Get('view.skin');
        $sCacheName = $sCacheDir."/".md5(serialize($aFiles).'_head').".{$sType}";
        $sPathServer = Config::Get('path.root.server');
        $sPathWeb    = Config::Get('path.root.web');
        /**
         * Если кеш существует, то берем из кеша
         */
        if(!file_exists($sCacheName)) {
            /**
             * Создаем директорию для кеша текущего скина,
             * если таковая отсутствует
             */
            if(!is_dir($sCacheDir)){
                @mkdir($sCacheDir);
            }
            /**
             * Считываем содержимое
             */
            ob_start();
            foreach ($aFiles as $sFile) {
                // если файл локальный
                if (strpos($sFile,Config::Get('path.root.web'))!==false) {
                    $sFile=$this->GetServerPath($sFile);
                }
                list($sFile,)=explode('?',$sFile,2);
                /**
                 * Если файл существует, обрабатываем
                 */
                if($sFileContent = @file_get_contents($sFile)) {
                    if($sType=='css'){
                        list(,$sExt)=explode('.',$sFile,2);

                        $sFileContent = $this->ConvertPathInCss($sFileContent,$sFile);
                        if($sExt=='scss') {
                            $sFileContent = $this->ParseSass($sFileContent);
                        }
                        $sFileContent = $this->CompressCss($sFileContent);
                    } elseif($sType=='js') {
                        $sFileContent = $this->CompressJs($sFileContent);
                    }
                    print $sFileContent;
                }
            }
            $sContent = ob_get_contents();
            ob_end_clean();

            /**
             * Создаем новый файл и сливаем туда содержимое
             */
            file_put_contents($sCacheName,$sContent);
            @chmod($sCacheName, 0766);
        }
        /**
         * Возвращаем имя файла, заменяя адрес сервера на веб-адрес
         */
        return $this->GetWebPath($sCacheName);
    }

    /**
     * Создает sass-парсер и инициализирует его конфигурацию
     *
     * @return bool
     */
    protected function InitSassParser() {
        /**
         * Получаем параметры из конфигурации
         */
        $aParams = Config::Get('plugin.phamlp.sass');
        $this->oSassParser =($aParams['use']) ? new SassParser($aParams) : null;
        /**
         * Если компрессор не создан, завершаем работу инициализатора
         */
        if(!$this->oSassParser) return false;

        return true;
    }

    /**
     * Выполняет преобразование SASS файлов
     *
     * @param  string $sContent
     * @return string
     */
    protected function ParseSass($sContent) {
        $this->InitSassParser();

        if(!$this->oSassParser) return $sContent;
        /**
         * Парсим sass и отдаем обработанный результат
         */
        return $this->oSassParser->toCss($sContent,false);
    }
}
?>
