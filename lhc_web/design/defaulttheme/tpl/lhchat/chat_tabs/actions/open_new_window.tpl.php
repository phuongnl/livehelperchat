<a class="material-icons mr-0" data-title="<?php echo htmlspecialchars($chat->nick,ENT_QUOTES);?>" onclick="lhinst.startChatCloseTabNewWindow('<?php echo $chat->id;?>',$('#tabs'),$(this).attr('data-title'))" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in a new window');?>">open_in_new</a>