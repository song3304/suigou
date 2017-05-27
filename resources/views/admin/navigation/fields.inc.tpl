<div class="form-group">
	<label class="col-md-3 control-label" for="name">名称</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入名称" value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="sid">门店</label>
	<div class="col-md-9">
		<select name="sid" class="select-model form-control" value="<{$_data.sid}>" data-model="admin/shop" data-text="{{name}}" data-placeholder="请选择门店."></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="porder">排序</label>
	<div class="col-md-9">
		<input type="text" id="porder" name="porder" class="form-control" placeholder="请输入排序" value="<{$_data.porder}>">
	</div>
</div>
<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>
