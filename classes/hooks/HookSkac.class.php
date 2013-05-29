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
class PluginSkac_HookSkac extends Hook {

    /*
     * Регистрация событий на хуки
     */
    public function RegisterHook() {

        $this->AddHook('template_html_head_end', 'insert_config');
        $this->AddHook('template_topic_show_info', 'insert_topic_info');
    }
    /**
     * Add Skac config
     *
     * @return string
     */
    public function insert_config()
    {
        $bAjaxComments = Config::Get('plugin.skac.use_ajax_comments');
        $bAjaxCut = Config::Get('plugin.skac.use_ajax_cut');

        $aPluginList = Engine::getInstance()->GetPlugins();
        foreach ($aPluginList as $sPlugin=>$oPlugin){
            if (in_array($sPlugin,Config::Get('plugin.skac.comments_off_plugins'))) $bAjaxComments = 0;
            if (in_array($sPlugin,Config::Get('plugin.skac.cut_off_plugins'))) $bAjaxCut = 0;
        }
        $this->Viewer_Assign('bAjaxComments',$bAjaxComments);
        $this->Viewer_Assign('bAjaxCut',$bAjaxCut);
        
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'hook_html_head_end.tpl');
    }
    public function insert_topic_info($aData)
    {
        $this->Viewer_Assign('oTopic',$aData['topic']);
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'hook_topic_show_info.tpl');
    }
}
?>
