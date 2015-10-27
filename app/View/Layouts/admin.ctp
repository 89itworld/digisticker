<?php
	echo $this->element('header');
	echo $this->element('nav');
	echo $this->fetch('content');
	echo $this->element('footer');
?>