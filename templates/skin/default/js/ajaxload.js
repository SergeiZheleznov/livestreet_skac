var ls = ls || {};

ls.skac =( function ($) {

    this.isBusy = false;
    
    this.busy = function(target,status){
        if (status){
            target.addClass('busy');
            this.isBusy = true;
        } else {
            target.removeClass('busy');
            this.isBusy = false;
        }
    }
    this.getComments = function (itopic,target) {
        if (this.isBusy) {
            return;
        }
        this.busy(target,1);
        oParent = target.parents('article');


        ls.ajax(aRouter['ajax']+'skacomments', {'itopic':itopic}, function(data) {
            if (data.bStateError) {
                ls.msg.error(data.sMsgTitle,data.sMsg);
            } else {

                $('#skac-wrapper').remove();
                oParent.after('<div id="skac-wrapper">'+data.sText+'<input type="hidden" id="comment_last_id" value="'+data.iMaxIdComment+'" /><input type="hidden" id="comment_use_paging" value="" /></div><script>$(\'#window_upload_img\').jqm(); ls.blocks.initSwitch(\'upload-img\');</script>');
                ls.comments.init();
                if (data.iCommentsCount<1) {
                    ls.comments.toggleCommentForm(0);
                }
                $.scrollTo('#comments', 1000, {offset: -150});
                target.toggleClass('skac-on');
            }
            this.busy(target,0);
        }.bind(this));
    }

    this.getFullText = function (itopic,target) {
        target.append('<div class="skac-cut-loading"></div>');
        oParent = target.parents('article');
        ls.ajax(aRouter['ajax']+'skafull', {'itopic':itopic}, function(data) {
            if (data.bStateError) {
                ls.msg.error(data.sMsgTitle,data.sMsg);
            } else {
                oParent.children('.topic-content').html(data.sText);
            }
        }.bind(this));
    }
    this.getShortText = function (itopic,target) {
        target.append('<div class="skac-cut-loading"></div>');
        oParent = target.parents('article');
        ls.ajax(aRouter['ajax']+'skashort', {'itopic':itopic}, function(data) {
            if (data.bStateError) {
                ls.msg.error(data.sMsgTitle,data.sMsg);
            } else {
                oParent.children('.topic-content').html(data.sText);
                $.scrollTo(oParent.next(), 1000, {offset: -150});
            }
        }.bind(this));
    }
   
    return this;
}).call(ls.skac || {},jQuery);




jQuery(document).ready(function($){

if ( ls.registry.get('plugin.skac.use_ajax_comments') ){
    $( ls.registry.get('plugin.skac.comments_link') ).on('click', function() {
        var skcc = $(this).parents('.topic').find(ls.registry.get('plugin.skac.count_comments'));

        ls.hook.add('ls_comments_load_after', function(){
            skcc.text($('#count-comments').text());
        });

        var skac = $(this).parents('.topic').find(".skac-topic-data");    
        if ($(this).hasClass('skac-on')){
            $('#skac-wrapper').slideUp(300,function(){
                $('#skac-wrapper').remove();
            });
            $(this).removeClass('skac-on');
            return false;
        }
        if (skac.data('comments') < ls.registry.get('plugin.skac.comments_limit')){
            ls.skac.getComments(skac.data('idx'),$(this));
            return false; 
        }
    
    });
}

if ( ls.registry.get('plugin.skac.use_ajax_cut') ){
    $(ls.registry.get('plugin.skac.cut_link')).on('click', function() {
        if ( $(this).attr('title') == ls.registry.get('plugin.skac.lang_readmore') && $(this).attr('href').indexOf(DIR_WEB_ROOT) != null ) {
            var skac = $(this).parents('.topic').find(".skac-topic-data");
            ls.skac.getFullText(skac.data('idx'),$(this));
            return false;
        }
        return true;
    });
    $( ls.registry.get('plugin.skac.cut_link') ).each(function(){
        $(this).addClass('link-dotted');
    });
}



});