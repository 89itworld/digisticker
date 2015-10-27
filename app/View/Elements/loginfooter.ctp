    <?php echo $this->Html->script(array('jquery','bootstrap.min'));?>
    <script>
	$(document).ready(function(){
		$("#username").focus();
	});
</script>
<script>
$(document).ready(function(){
	$('#loginerr').show(100);	
	$('#loginerr').delay(3000).fadeOut('slow');	
});
</script>
</body>
</html>