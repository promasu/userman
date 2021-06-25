<?php 
function showMiddle() {
	$ret = "<span class='col-sm-2 middle'>\n";
	$ret .= "<button class='btn toggle' data-cmd='allleft'> <i class='fa fa-arrow-left' ></i></button><br/>";
	$ret .= "<button class='btn toggle' data-cmd='swap'> <i class='fa fa-arrows-h'></i></button><br/>";
	$ret .= "<button class='btn toggle' data-cmd='allright'><i class='fa fa-arrow-right'></i></button><br/>";
	$ret .= "</span>\n";
	return $ret;
}
?>
<div class="fpbx-container">
	<h1>Users Template</h1>
	<ul class="nav nav-tabs" id="template-tabs" role="tablist">
  		<li data-name="users" class="change-tab active"><a href="#users" role="tab" data-toggle="tab"><?php echo _("Members") ?></a></li>
	</ul>
	<form method='post' id="form_usertemplate" name ="form_usertemplate" action='config.php?display=userman#ucptemplates' class="fpbx-submit">
		<input type="hidden" name="type" value="savemembers">
		<input type="hidden" name="submittype" value="gui">
		<div class="tab-content display">
			<div id='users' class='tab-pane active'>
				<div class = "row">
					<fieldset class='users_list ui-sortable left col-sm-5' id='members' data-otherid='selected_members'>
						<legend> <?php echo _("Members")?> </legend>
						<?php foreach ($members as $key => $val) {
							echo "<span class='dragitem' data-member='".$val['id']."'>".$val['username']."</span>\n";
						}?>
					</fieldset>
					<?php echo showMiddle(); ?>
					<fieldset class='users_list ui-sortable right col-sm-5' id='selected_members' data-otherid='members'>
						<legend> <?php echo _("Selected Members")?> </legend>
					</fieldset>
				</div>
			</div>
		</div>
	</form>
</div>
<script type='text/javascript'>

	$(document).ready(function() {			
		Sortable.create(members, {
			group: 'usr',
			multiDrag: true,
			selectedClass: "selected"
		});
		Sortable.create(selected_members, {
			group: 'usr',
			multiDrag: true,
			selectedClass: "selected"
		});

		$(window).resize(function() { set_height(); });
		function set_height() {
			var height = 0;
			$("#tabs>.tab:visible").height('auto').each(function(){
				console.log($(this).height());
				height = $(this).height() > height ? $(this).height() : height;
			}).height(height);
		}
		// Enable 'Move All' buttons
		$('.toggle').click(function(e) {
			e.preventDefault();
			var cmd=$(this).data('cmd');
			var tabname = $(".nav-tabs .active").data('name');
			var thistab = $('#'+tabname).children();
			console.log(thistab.children());
			var left = thistab.children('.left');
			var right = thistab.children('.right');
			if (cmd == 'allleft') {
				right.children('span').each(function() { $(this).appendTo(left); });
			} else if (cmd == 'allright') {
				left.children('span').each(function() { $(this).appendTo(right); });
			} else {
				oldleft = left.children('span');
				right.children('span').each(function() { $(this).appendTo(left); });
				oldleft.each(function() { $(this).appendTo(right); });
			}

		});
		$('form').submit(function() {
			var form=$(this), mem_id=[];
			$('#selected_members>span').each(function() {
				form.append('<input type="hidden" name="selected_usermembers[]" value="'+$(this).attr('data-member')+'">');
			});
			console.log('mem',mem_id);
			return true;
		});
		$("#cancel").click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			window.location = '?display=userman#ucptemplates';
		});


	})
	
</script>
