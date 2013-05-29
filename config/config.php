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

$config = array();

$config['use_ajax_comments'] = 1; // Использовать раскрытие комментариев
$config['comments_limit'] = 10; // Если коментарии превысят это значение ссылка будет работать как обычно

$config['use_ajax_cut'] = 1; // по клике на cut динамически подгружать полный текст топика


/*

В том случае если вы сами изменяли шаблон в можете самостоятельно задать селекторы ссылок, на которые
будут повешены события ajax данного плагина

Важно: если на своем сайте вы используете плагины, динамически обновляющие содержимое страниц, вроде 
плагина Ajax load, то вам НЕОБХОДИМО вручную изменить шаблоны для того чтобы ссылки тега cut были
подчеркнуты пунктиром. В противном случае плагин будет продолжать работать, но ссылки ката выделяться
пунктиром перестанут.

Например: в шаблоне topic_topic.tpl находим

<a href="{$oTopic->getUrl()}#cut" title="{$aLang.topic_read_more}">

и меняем на 

<a href="{$oTopic->getUrl()}#cut" class="link-dotted" title="{$aLang.topic_read_more}">

*/

$config['comments_link'] = '.topic-info-comments a'; // селектор ссылок на коментарии
$config['cut_link'] = '.topic-content a[href$=#cut]:last-child'; // селектор ката
$config['count_comments'] = '.topic-info-comments a span'; // селектор счетчика комментариев


// Совместимость с шаблоном Simple
if (Config::Get('view.skin') == 'simple'){
	$config['comments_link'] = '.info-top .comments-link a';
}


// Плагины, не совместимые с работой ajax cut'a
$config['cut_off_plugins'] = array();
// Плагины не совместимые с работой ajax комментариев
$config['comments_off_plugins'] = array();

return $config;
