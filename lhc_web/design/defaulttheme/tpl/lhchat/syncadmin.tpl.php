<?php if ($chat->status != erLhcoreClassModelChat::STATUS_CHATBOX_CHAT) : 

    $lastOperatorChanged = false;
    $lastOperatorId = false;
    $lastOperatorNick = '';

    foreach ($messages as $msg) :
    
        if ($lastOperatorId !== false && ($lastOperatorId != $msg['user_id'] || $lastOperatorNick != $msg['name_support'])) {
            $lastOperatorChanged = true;
        } else {
            $lastOperatorChanged = false;
        }
        
        $lastOperatorId = $msg['user_id'];
        $lastOperatorNick = $msg['name_support'];

        if ($msg['msg'] == '') {
            continue;
        }

        $msgRendered = erLhcoreClassBBCode::make_clickable(htmlspecialchars($msg['msg']));
        $msgRenderedMedia = strip_tags($msgRendered);
        $emojiMessage = trim(preg_replace('#(x1F642|[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}])#u','', $msgRendered)) == '';

if ($msg['user_id'] == -1) : ?>
<div class="message-row system-response" id="msg-<?php echo $msg['id']?>" title="<?php echo erLhcoreClassChat::formatDate($msg['time']);?>">
    <div class="msg-date"><?php echo erLhcoreClassChat::formatDate($msg['time']);?></div><i><span class="usr-tit sys-tit"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmin','System assistant')?></span><div class="msg-body"><?php echo $msgRendered?></div></i>
</div>
<?php else : ?>
<div class="message-row<?php echo $msg['user_id'] == 0 ? ' response' : ' message-admin'.($lastOperatorChanged == true ? ' operator-changes' : '') ?>" data-op-id="<?php echo $msg['user_id']?>" title="<?php echo erLhcoreClassChat::formatDate($msg['time']);?>" id="msg-<?php echo $msg['id']?>">
    <div class="msg-date"><?php echo erLhcoreClassChat::formatDate($msg['time']);?></div><span class="usr-tit<?php echo $msg['user_id'] == 0 ? ' vis-tit' : ' op-tit'?>"><?php echo $msg['user_id'] == 0 ? '<i class="material-icons chat-operators mi-fs15 mr-0">'.($chat->device_type == 0 ? '&#xE30A;' : ($chat->device_type == 1 ? '&#xE32C;' : '&#xE32F;')).'</i> '.htmlspecialchars($chat->nick) : '<i class="material-icons chat-operators mi-fs15 mr-0">&#xE851;</i>'.htmlspecialchars($msg['name_support']) ?></span>
        <div class="msg-body<?php ($msgRenderedMedia == '') ? print ' msg-body-media' : ''?><?php ($emojiMessage == true) ? print ' msg-body-emoji' : ''?>">
            <?php echo $msgRendered?>
        </div>
    </div>
<?php endif;?>

	<?php endforeach; ?>
<?php else : ?>
	<?php foreach ($messages as $msg ) : ?>
<div class="message-row<?php echo $msg['user_id'] == 0 ? ' response' : ' message-admin'?>" id="msg-<?php echo $msg['id']?>" title="<?php echo erLhcoreClassChat::formatDate($msg['time']);?>">
	<div class="msg-date"><?php echo erLhcoreClassChat::formatDate($msg['time']);?></div>
	<span class="usr-tit<?php echo $msg['user_id'] == 0 ? ' vis-tit' : ' op-tit'?>"><?php echo $msg['user_id'] == 0 ? htmlspecialchars($msg['name_support']) : htmlspecialchars($chat->nick) ?></span>
    <div class="msg-body<?php ($msgRenderedMedia == '') ? print ' msg-body-media' : ''?><?php ($emojiMessage == true) ? print ' msg-body-emoji' : ''?>">
        <?php echo $msgRendered?>
    </div>
</div>
<?php endforeach; ?>
<?php endif;?>