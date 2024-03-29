<div class="form-group">
	<label class="col-md-3 control-label" for="id">指定用户</label>
	<div class="col-md-9">
		<select id="id" name="id" class="select-model form-control" data-model="admin/member" data-text="{{username}}" data-term="{{username}}" data-placeholder="请输入该门店所属用户." value="<{$_data.id}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name">门店名</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" placeholder="请输入门店名..." value="<{$_data.name}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="status">状态</label>
	<div class="col-md-9">
		<select id="status" name="status" class="form-control">
			<option value="0"<{if empty($_data.status)}> selected="selected"<{/if}>>未审核</option>
			<option value="1"<{if $_data.status==1}> selected="selected"<{/if}>>已审核</option>
			<option value="-1"<{if $_data.status==-1}> selected="selected"<{/if}>>关闭</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="province">省</label>
	<div class="col-md-9">
		 <select id="province" name="province" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"0"}' data-model="admin/area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入省" value="<{$_data.province|default:110000}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="city">市</label>
	<div class="col-md-9">
		 <select id="city" name="city" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"<{$_data.province|default:110000}>"}' data-model="admin/area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入市" value="<{$_data.city|default:110100}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="area">区</label>
	<div class="col-md-9">
        <select id="area" name="area" class="select-model form-control input text" data-id="{{area_id}}" data-params='{"f[parent_id]":"<{$_data.city|default:110100}>"}' data-model="admin/area" data-text="{{area_name}}" data-term="{{area_name}}" data-placeholder="请输入市" value="<{$_data.area|default:110101}>"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="address">地址</label>
	<div class="col-md-9">
		<input type="text" id="address" name="address" class="form-control" placeholder="请输入地址..." value="<{$_data.address}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="phone">联系电话</label>
	<div class="col-md-9">
		<input type="text" id="phone" name="phone" class="form-control" placeholder="请输入联系电话..." value="<{$_data.phone}>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="longitude">经度</label>
	<div class="col-md-9">
		<input type="text" id="longitude" name="longitude" class="form-control" placeholder="请输入经度..." value="<{$_data.longitude}>" required readonly>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="latitude">纬度</label>
	<div class="col-md-9">
		<input type="text" id="latitude" name="latitude" class="form-control" placeholder="请输入纬度..." value="<{$_data.latitude}>" required readonly>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="latitude">地图</label>
	<div class="col-md-9">
		<input type="hidden" id="full_address" name="full_address" value="<{$_data.full_address}>"/>
		<div id="map" style="height:550px;border:#ccc solid 1px;"></div>
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
	var method = {cacheData: {}};
	method.getData = function(url, params) {
		var key = JSON.stringify({url: url, params: params});
		var $dfd = jQuery.Deferred();

		if (typeof method.cacheData[key] != 'undefined')
			$dfd.resolve(method.cacheData[key]);
		else {
			$.POST(url, params).done(function(json, textStatus, jqXHR){
				if (json.result == 'success' || json.result == 'api') {
					var items = json.data.data;
					method.cacheData[key] = items;
					$dfd.resolve(method.cacheData[key]);
				} else {
					var args = arguments;
					$dfd.reject.apply($dfd, args);
				}
			}).fail(function(){
				var args = arguments;
				$dfd.reject.apply($dfd, args);
			});
		}
		return $dfd.promise();
	};
	method.replaceData = function(data, format)
	{
		return format.replace(/\{\{([\w\.]+)\}\}/g, function($0, $1){
			var o = $1.split('.');
			var d = data;
			for(var i = 0; i < o.length; ++i)
			{
				var n = o[i];
				if (typeof d[ n ] != 'undefined')
					d = d[n];
				else 
					return null;
			}
			return d;
		});
	};
	method.format = function(items, id, selection, text, pid) {
		var result = [];
		for(var i = 0; i < items.length; ++i) {
			var d = {
				'id': id ? method.replaceData(items[i], id) : items[i].id, 
				'text': text ? method.replaceData(items[i], text) : items[i].text,
				'selection': selection ? method.replaceData(items[i], selection) : items[i].selection,
				'pid': pid ? method.replaceData(items[i], pid) : items[i].pid
			};
			if (typeof items[i].children == 'object' && typeof items[i].children.length != 'undefined')
				d.children = method.format(items[i].children, id, selection, text, pid);
			result.push(d);
		}
		return result;
	};
	method.recursive = function(items, prefix) {
		prefix = typeof prefix == 'undefined' ? '' : prefix;
		var result = [];
		for(var i = 0; i < items.length; ++i) {
			var v = items[i];
			var _class = 'treeline ';
			if (i === 0 && !prefix) //首节点
				_class += 'top-';
			else if (i == items.length - 1) //尾节点
				_class += 'bottom-';
			else
				_class += 'center-';
			_class += v.children ? 'open' : 'line';

			var d = {
				'id': v.id,
				'selection': v.selection,
				'text': prefix + '<span class="'+_class+'"></span>' + v.text
			};
			result.push(d);
			if (v.children)
			{
				var ds = method.recursive(v.children, prefix + (i == items.length - 1 ? '<span class="treeline blank"></span>' : '<span class="treeline blank-line"></span>'));
				for(var j = 0; j < ds.length; ++j)
					result.push(ds[j]);
			}
		}
		return result;
	};


	$(function(){
		$("#province").on('change',function(){
			$('#city').data('params',{"f[parent_id]":$(this).val()});
			select_change.call($('#city')[0]);
		});
		$("#city").on('change',function(){
			$('#area').data('params',{"f[parent_id]":$(this).val()});
			select_change.call($('#area')[0]);
		});
		
		function select_change(){
			var $this = $(this);
				var id = $this.data('id');
				var text = $this.data('text');
				var selection = $this.data('selection') ? $this.data('selection') : text;
				var params = $this.data('params');
				var values = $this.attr('value') ? $this.attr('value').split(',') : $this.val();
				var url = $.baseuri + $this.data('model')+'/data/json';
				params = $.extend(true, {}, {all: 'true'}, params);
				method.getData(url, params).done(function(json){
					var data = method.format(json, id, selection, text); 
					$this.html('');
					$this.select2($.extend(true, {}, {language: "zh-CN", data: data, allowClear: true}));
					//初始值
					//$this.trigger("change");
					$this.val(values ? values : null).trigger("change");
				});
		}
		
	});
})(jQuery);	
</script>