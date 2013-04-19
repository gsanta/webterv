	<div id="footer-wrap">
		<?php
			if(isset($_SESSION['user_data'])) :
		?>
		<span>Név: </span>
		<span><?php echo $_SESSION['user_data']['name']; ?></span>
		<?php endif; ?>
	</div>
</body>
</html>