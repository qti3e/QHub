<div class="row">
	<div class="col-md-3 col-sm-12 col-md-push-9">
		<div class="row text-center">
			<img class="img-circle" src="https://www.gravatar.com/avatar/<?php echo md5(trim(strtolower('qti3eqti3e@gmail.com')));?>">
			<br><b><?php echo $this->fname.' '.$this->lanme; ?></b>
		</div>
		<hr>
		<div class="row panel panel-black">
			<div class="panel-heading"><h3>Todo</h3></div>
			<ol class="list-group panel-body" id="todo">
				<li class="list-group-item">
					A
					<div class="actions">
						<span data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
					</div>
				</li>
				<li class="list-group-item">
					B
					<div class="actions">
						<span data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
					</div>
				</li>
				<?php ?>
				<li class="list-group-item">
					C
					<div class="actions">
						<span data-xz="remove" data-todo="C" data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
					</div>
				</li>
			</ol>
			<form id="new_todo" method="post" class="panel-footer form-inline">
				<div class="form-group">
					<input id="todo_text" type="text" placeholder="Type and press enter..." class="col-sm-10 form-control" />
					<div class="col-sm-2">
						<button class="form-control btn btn-black">Add</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-9 col-sm-12 col-md-pull-3">
		<div class="panel panel-black">
			<div class="panel-heading"><h2>Repositories</h2></div>
			<ul class="list-group panel-body" id="repositories">
				<li class="list-group-item">
					<h4><a href="empty.php">Name</a></h4>
					<p>Description</p>
				</li>
				<li class="list-group-item">
					<h4><a href="empty.php">Name</a></h4>
					<p>Description</p>
				</li>
				<li class="list-group-item">
					<h4><a href="empty.php">Name</a></h4>
					<p>Description</p>
				</li>
				<li class="list-group-item">
					<h4><a href="empty.php">Name</a></h4>
					<p>Description</p>
				</li>
			</ul>
			<div class="panel-footer">
				<nav aria-label="Page navigation" class="text-center">
					<ul class="pagination">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>
<?php ob_start(); ?>
<script type="application/javascript">
	$('#new_todo').submit(function(){
		$.post('?user/new_todo&json',{text:$('#todo_text').val()}).done(function(data){
			data    = JSON.parse(data);
			if(data !== false){
				var text    = data;
			}
		});
		$('#new_todo').reset();
		return false;
	});
</script>
<?php $script = ob_get_contents(); ob_end_clean(); ?>