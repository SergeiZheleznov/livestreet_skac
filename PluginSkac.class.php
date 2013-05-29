<?php
/*-------------------------------------------------------
*
*   Plugin "Skac. Загрузка коментариев в ленту топиков на ajax"
*   Author: Zheleznov Sergey (skif)
*   Site: livestreet.ru/profile/skif/
*   Contact e-mail: sksdes@gmail.com
*
---------------------------------------------------------
*/
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginSkac extends Plugin {

    // Объявление делегирований (нужны для того, чтобы назначить свои экшны и шаблоны)
    public $aDelegates = array(
    );

    // Объявление переопределений (модули, мапперы и сущности)
    protected $aInherits=array(
        'action'=>array('ActionAjax'),
    );
    // Активация плагина
    public function Activate() {
        return true;
    }
    // Деактивация плагина
    public function Deactivate(){
        return true;
    }
    // Инициализация плагина
    public function Init() {
        $this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."/css/style.css"); // Добавление своего CSS
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/ajaxload.js');

    }
}
?>
