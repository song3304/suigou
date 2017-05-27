<div class="form-group">
	<label class="col-md-3 control-label" for="sid">门店</label>
	<div class="col-md-9">
		<select name="sid" id="sid" class="select-model form-control" value="<{if !empty($_data->sid)}><{$_data->sid}><{else}>0<{/if}>" data-model="admin/shop" data-text="{{name}}" data-placeholder="请选择门店名字"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="nid">栏目</label>
	<div class="col-md-9">
		<select name="nid" id="nid" class="form-control" placeholder="请选择栏目名字" data-val="<{if !empty($_data->nid)}><{$_data->nid}><{/if}>">
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="title">标题</label>
	<div class="col-md-9">
		<input type="text" id="title" name="title" class="form-control" placeholder="请输入标题" value="<{$_data.title}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="pid">链接跳转到商品</label>
	<div class="col-md-9">
		<select name="pid" id="pid" class="select-model form-control" value="<{if !empty($_data->pid)}><{$_data->pid}><{else}>0<{/if}>" data-model="admin/product" data-text="{{title}}" data-placeholder="请选择点击banner跳到哪个商品"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="url">url</label>
	<div class="col-md-9">
		<input type="text" id="url" name="url" class="form-control" placeholder="如果选择跳转商品,不需要输入url" value="<{$_data.url}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="status">状态</label>
	<div class="col-md-9">
		<input type="radio" name="status" value="1" <{if $_data.status eq '1'||$_data.status===null}>checked="checked"<{/if}>>显示
		<input type="radio" name="status" value="0" <{if $_data.status eq '0'}>checked="checked"<{/if}>>隐藏
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="cover">封面</label>
	<div class="col-md-9">
		<input type="hidden" id="cover" name="cover" class="form-control" placeholder="请输入..." value="<{$_data.cover|default:0}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="porder">排序</label>
	<div class="col-md-9">
		<input type="text" id="porder" name="porder" class="form-control" placeholder="请输入排序" value="<{$_data.porder|default:0}>">
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
		$.POST('<{'admin/navigation/data/json'|url}>', {'filters[sid][in]': value}, function(json){
			if (json.result == 'api')
			{
				var items = json.data.data;
				for(var i = 0; i < items.length; ++i)
					$('<option value="'+items[i].id+'">'+items[i].name+'</option>').appendTo($nid);
				
				$nid.val(default_value).select2({language: 'zh-CN'});
			}
		}, false);
	}).trigger('change');
	
	$('#pid').on('change',function(){
		$this = $(this);
		var value = $this.val();
		if(value != null){
			$('#url').val('');
			$('#url').prop('readOnly',true);
		}else{
			$('#url').removeAttr('readOnly');
		}
	});
});
})(jQuery);
</script>