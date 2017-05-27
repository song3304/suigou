<div class="form-group">
	<label class="col-md-3 control-label" for="sid">门店</label>
	<div class="col-md-9">
		<select id="sid" name="sid" class="select-model form-control" data-model="admin/shop" data-text="{{name}}" data-term="{{name}}" data-placeholder="请输入门店名字" value="<{$_data.sid}>"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="nid">栏目</label>
	<div class="col-md-9">
		<select name="nid" id="nid" class="form-control" data-placeholder="请选择栏目名字" data-val="<{$_data.nid}>" >
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="porder">排序</label>
	<div class="col-md-9">
		<input type="text" id="porder" name="porder" class="form-control" placeholder="请输入这个排序" value="<{$_data.porder}>">
	</div>
</div>

<div class="form-group form-actions">
	<div class="col-md-9 col-md-offset-3">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重设</button>
	</div>
</div>

<script>
(function($){
$().ready(function(){
	var $nid = $('#nid');
	$('#sid').on('change', function(){
		$this = $(this);
		var value = $this.val();
		var default_value = $nid.data('val');

		$nid.empty();

		if (!value) {
			$nid.select2({language: 'zh-CN'});
			return true;
		}
	$.POST('<{'admin/navigation/data/json'|url}>', {'f[sid]': value}, function(json){
			if (json.result == 'api')
			{
				var items = json.data.data;
				for(var i = 0; i < items.length; ++i)
					$('<option value="'+items[i].id+'">'+items[i].name+'</option>').appendTo($nid);
				
				$nid.val(default_value).select2({language: 'zh-CN'});
			}
		}, false);
	}).trigger('change');
});
})(jQuery);
</script>