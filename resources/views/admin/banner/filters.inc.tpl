<!-- Form Content -->
<form action="<{'admin'|url nofilter}>/<{block "name"}><{/block}>/" method="GET" class="form-bordered form-horizontal">
	<input type="hidden" name="base" value="<{$_base}>">
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="sid">店铺</label>
		<div class="col-md-9">
			<select id="sid" name="f[sid][in][]" class="select-model form-control" data-model="admin/shop" data-text="{{name}}" data-term="{{name}}" data-placeholder="请输入门店名字" value="<{$_filters.sid.in|default:[]|implode:','}>" multiple="multiple"></select>
		</div>
	</div>
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="nid">导航</label>
		<div class="col-md-9">
			<select name="f[nid]" id="nid" class="form-control" data-placeholder="请选择栏目名字" data-val="<{if $_filters.nid}><{$_filters.nid}><{/if}>">
			</select>
		</div>
	</div>
	<div class="form-group col-sm-4">
		<label class="col-md-3 control-label" for="created_at-min">加入时间</label>
		<div class="col-md-9">
			<div class="input-group input-daterange">
				<input type="text" id="created_at-min" name="f[created_at][min]" class="form-control text-center" placeholder="开始时间" value="<{$_filters.created_at.min}>">
				<span class="input-group-addon">～</span>
				<input type="text" id="created_at-max" name="f[created_at][max]" class="form-control text-center" placeholder="结束时间" value="<{$_filters.created_at.max}>">
			</div>
		</div>
	</div>
	<div class="form-group col-sm-12 text-right">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> 检索</button>
		<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重置</button>
	</div>
	<div class="clearfix"></div>
</form>
<!-- END Form Content -->
<script>
(function($){
	$().ready(function(){
		var $nid = $('#nid');
		$('#sid').on('change', function(){
			$this = $(this);
			var value = $this.val();
			var default_value = $nid.data('val');
	
			$nid.empty();
			//$('<option value="0">请选择栏目</option>').appendTo($nid);
	
			if (!value) {
				$nid.select2({language: 'zh-CN'});
				return true;
			}
			$.POST('<{'admin/navigation/data/json'|url}>', {'f[sid][in]': value}, function(json){
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