<div class="row">
	<div class="col-md-3 col-sm-12 col-md-push-9">
		<div class="row text-center">
			<img class="img-circle" src="https://www.gravatar.com/avatar/<?php echo md5(trim(strtolower('qti3eqti3e@gmail.com')));?>">
			<br><b>Alireza Ghadimi</b>
		</div>
		<hr>
		<div class="row panel panel-black">
			<div class="panel-heading"><h3>Todo</h3></div>
			<ol class="list-group panel-body" id="todo">
				<li class="list-group-item">
					A
					<div class="actions">
						<span data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
						<span data-toggle="tooltip" title="Remove" class="glyphicon glyphicon-remove"></span>
					</div>
				</li>
				<li class="list-group-item">
					B
					<div class="actions">
						<span data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
						<span data-toggle="tooltip" title="Remove" class="glyphicon glyphicon-remove"></span>
					</div>
				</li>
				<li class="list-group-item">
					C
					<div class="actions">
						<span data-toggle="tooltip" title="Done!" class="glyphicon glyphicon-ok"></span>
						<span data-toggle="tooltip" title="Remove" class="glyphicon glyphicon-remove"></span>
					</div>
				</li>
			</ol>
			<form id="new_todo" class="panel-footer form-inline">
				<div class="form-group">
					<input type="text" placeholder="Type and press enter..." class="col-sm-10 form-control" />
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