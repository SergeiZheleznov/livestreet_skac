<?php
/*-------------------------------------------------------
*
*	Plugin "Skac. Загрузка коментариев в ленту топиков на ajax"
*	Author: Zheleznov Sergey (skif)
*	Site: livestreet.ru/profile/skif/
*	Contact e-mail: sksdes@gmail.com
*
---------------------------------------------------------
*/

class PluginSkac_ActionAjax extends PluginSkac_Inherit_ActionAjax {

    protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEvent('skacomments','EventAjaxCommentsList');
        $this->AddEvent('skafull','EventAjaxFull');
        $this->AddEvent('skashort','EventAjaxShort');
	}

    public function EventAjaxCommentsList(){
       

        $oTopic = $this->Topic_GetTopicById(getRequest('itopic'));
        if (!Config::Get('module.comment.nested_page_reverse') and Config::Get('module.comment.use_nested') and Config::Get('module.comment.nested_per_page')) {
            $iPageDef=ceil($this->Comment_GetCountCommentsRootByTargetId($oTopic->getId(),'topic')/Config::Get('module.comment.nested_per_page'));
        } else {
            $iPageDef=1;
        }
        $iPage=1;
        $aReturn=$this->Comment_GetCommentsByTargetId($oTopic->getId(),'topic',$iPage,Config::Get('module.comment.nested_per_page'));
        $iMaxIdComment=$aReturn['iMaxIdComment'];
        $aComments=$aReturn['comments'];

        /**
         * Отмечаем дату прочтения топика
         */
        if ($this->oUserCurrent) {
            $oTopicRead=Engine::GetEntity('Topic_TopicRead');
            $oTopicRead->setTopicId($oTopic->getId());
            $oTopicRead->setUserId($this->oUserCurrent->getId());
            $oTopicRead->setCommentCountLast($oTopic->getCountComment());
            $oTopicRead->setCommentIdLast($iMaxIdComment);
            $oTopicRead->setDateRead(date("Y-m-d H:i:s"));
            $this->Topic_SetTopicRead($oTopicRead);
        }



        $this->Viewer_Assign('iTargetId',$oTopic->getId());
        $this->Viewer_Assign('iAuthorId',$oTopic->getUserId());
        $this->Viewer_Assign('sAuthorNotice',$this->Lang_Get('topic_author'));
        $this->Viewer_Assign('sTargetType','topic');
        $this->Viewer_Assign('iCountComment',$oTopic->getCountComment());
        $this->Viewer_Assign('sDateReadLast',$oTopic->getDateRead());
        $this->Viewer_Assign('bAllowNewComment',$oTopic->getForbidComment());
        $this->Viewer_Assign('sNoticeNotAllow',$this->Lang_Get('topic_comment_notallow'));
        $this->Viewer_Assign('sNoticeCommentAdd',$this->Lang_Get('topic_comment_add'));
        $this->Viewer_Assign('bAllowSubscribe',true);
        $this->Viewer_Assign('oSubscribeComment',$oTopic->getSubscribeNewComment());
        $this->Viewer_Assign('aPagingCmt',null );

        $this->Viewer_Assign('oConfig',Config::getInstance());
        
        $this->Viewer_Assign('aComments',$aComments);
        $this->Viewer_Assign('oUserCurrent',$this->User_GetUserCurrent());
        
        $this->Viewer_AssignAjax('sText',$this->Viewer_Fetch("comment_tree.tpl"));        

        $this->Viewer_AssignAjax('iMaxIdComment',$iMaxIdComment);
        $this->Viewer_AssignAjax('iCommentsCount',$oTopic->getCountComment());
    }

    public function EventAjaxFull(){
        $oTopic = $this->Topic_GetTopicById(getRequest('itopic'));
        $this->Hook_Run('topic_show',array("oTopic"=>$oTopic));

        $oViewerLocal=$this->Viewer_GetLocalViewer();
        $oViewerLocal->Assign('iTopicId',$oTopic->getId());
        $add = $oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'readmore_collapse.tpl');

        $this->Viewer_AssignAjax('sText',$oTopic->getText().$add);
    }
    public function EventAjaxShort(){
        $oTopic = $this->Topic_GetTopicById(getRequest('itopic'));

        $oViewerLocal=$this->Viewer_GetLocalViewer();
        $oViewerLocal->Assign('oTopic',$oTopic);
        $add = $oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'readmore_cut.tpl');

        $this->Viewer_AssignAjax('sText',$oTopic->getTextShort().$add);
    }
}
?>