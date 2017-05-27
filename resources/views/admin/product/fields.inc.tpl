<div class="form-group">
	<label class="col-md-3 control-label" for="title">标题</label>
	<div class="col-md-9">
		<input type="text" id="title" name="title" class="form-control" placeholder="请输入标题" value="<{$_data.title}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="sid">门店</label>
	<div class="col-md-9">
		<select id="sid" name="sid" class="select-model form-control" data-model="admin/shop" data-text="{{name}}" data-term="{{name}}" data-placeholder="请输入门店名字" value="<{$_data.sid}>"></select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="nids">栏目</label>
	<div class="col-md-9">
		<select name="nids[]" id="nids" class="form-control" data-placeholder="请选择栏目名字" data-val="<{if !empty($_data->navigations->toArray())}><{$_data->navigations->pluck('id')->toArray()|default:[]|implode:','}><{else}>0<{/if}>" multiple="multiple">
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="keywords">SEO关键字</label>
	<div class="col-md-9">
		<input type="text" id="keywords" name="keywords" class="form-control" placeholder="请输入SEO关键字" value="<{$_data.keywords}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="description">SEO描述</label>
	<div class="col-md-9">
		<input type="text" id="description" name="description" class="form-control" placeholder="请输入SEO描述" value="<{$_data.description}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="agent_rate">快递费/件</label>
	<div class="col-md-9">
		<input type="text" id="express_price" name="express_price" class="form-control" placeholder="请输入快递费" value="<{$_data.express_price}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="market_price">市场价格</label>
	<div class="col-md-9">
		<input type="text" id="market_price" name="market_price" class="form-control" placeholder="请输入这个市场价格" value="<{$_data.market_price}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="price">优惠价格</label>
	<div class="col-md-9">
		<input type="text" id="price" name="price" class="form-control" placeholder="请输入这个优惠价格" value="<{$_data.price}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="count">数量</label>
	<div class="col-md-9">
		<input type="text" id="count" name="count" class="form-control" placeholder="请输入这个库存" value="<{$_data.count}>">
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="title">封面</label>
	<div class="col-md-9">
		<select id="cover_aids" name="cover_aids[]" class="form-control hidden" multiple="multiple">
		<{if !empty($_data)}><{foreach $_data->covers as $item}>
			<option value="<{$item->cover_aid}>" selected="selected"></option>
		<{/foreach}><{/if}>
		</select>
		<div class="alert alert-info"><i class="fa fa-warning"></i> 可以上传20张图片作为产品的封面</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="address">内容</label>
	<div class="col-md-9">
		<textarea id="content1" name="content" class="" placeholder="请输入..."><{$_data->content}></textarea>
	</div>
	<div class="clearfix"></div>
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
	var $nids = $('#nids');
	$('#sid').on('change', function(){
		$this = $(this);
		var value = $this.val();
		var default_value = $nids.data('val');

		$nids.empty();
		//$('<option value="0">请选择栏目</option>').appendTo($nids);

		if (!value) {
			$nids.select2({language: 'zh-CN'});
			return true;
		}
		$.POST('<{'admin/navigation/data/json'|url}>', {'f[sid]': value}, function(json){
			if (json.result == 'api')
			{
				var items = json.data.data;
				for(var i = 0; i < items.length; ++i)
					$('<option value="'+items[i].id+'">'+items[i].name+'</option>').appendTo($nids);
				
				$nids.val(default_value).select2({language: 'zh-CN'});
			}
		}, false);
	}).trigger('change');
});
})(jQuery);
</script>