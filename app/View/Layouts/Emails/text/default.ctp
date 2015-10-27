<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title>Digi App</title>
</head>
<body>
	
	Hey,

	I downloaded this cool Digi Stickers App and I thought you would be interested in downloading it too. Check it out!
	<?php echo $this->Html->link($this->Html->image(FULL_BASE_URL."/stickerapp/img/Picture1.png",array("style"=>"margin:0 auto; width:290px"))); ?>
	<hr/>
	<p style="color:#555555">Please do not reply to this email address as this email address is not monitored.</p>

</body>
</html>
