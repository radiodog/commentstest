
<div id="<?= htmlspecialchars($comments[$i]['id'],ENT_QUOTES)?>" style="border: 4px solid black; padding-left: <?= $level.'px' ?>" >
	<a href="delete?id=<?= htmlspecialchars($comments[$i]['id'],ENT_QUOTES)?>">delete</a>
	<?= htmlspecialchars($comments[$i]['body'],ENT_QUOTES); ?>
		<form method="post">
        		<input type="text" name="body" required>
        		<input type="hidden" name="parrent_id" value="<?=htmlspecialchars($comments[$i]['id'],ENT_QUOTES) ?>">
        		<input type="submit" >  
  		</form>
  	<?php if(isset($data[$comments[$i]['id']])): ?>
  		<?php $this->showComments($data, $comments[$i]['id'], 20) ?>
	<?php endif ?>  		
</div>
