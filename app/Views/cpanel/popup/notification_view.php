<div class="modal fade" id="ViewRemind" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-group">
						<label for="datetime">Message Date Time:</label>
						<input type="text" name="reminderDate" class="form-control" >
					</div>
					<div class="form-group viewTitle">
						<label for="remindTitle">Title:</label>
						<input id="remindTitle" type="text" name="title" class="form-control">
					</div>
					<div class="form-group">
						<label for="content">Text:</label>
						<div id="content" style="border: 1px solid #3d4145;background-color: #3d4145;padding: 7px;">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span id="deoutput" style="float: left;"></span>
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!--  -->