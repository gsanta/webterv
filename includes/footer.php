	<div id="footer-wrap">

		<?php 
			foreach ($controller->get_personal_info() as $key => $value) {
				echo '<span class="key">' . $key . '</span>: ';
				echo '<span class="value">' . $value . '</span>, ';
			}
		?>
		
		
	</div>
</body>
</html>