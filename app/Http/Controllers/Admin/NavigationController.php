<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Navigation;
use Addons\Core\Controllers\ApiTrait;
use DB;

class NavigationController extends Controller
{
	use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{		
		$navigation = new Navigation;
		$size = $request->input('size') ?: config('size.models.'.$navigation->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.navigation.list');
	}

	public function data(Request $request)
	{
		$navigation = new Navigation;
		$builder = $navigation->newQuery()->with(['shop','products']);
		
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function(&$datalist){
		    foreach ($datalist as &$value){
		        $value['product_cnt'] =  $value->products->count();
		    }
		}, ['navigations.*']);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$navigation = new Navigation;
		$builder = $navigation->newQuery()->with(['shop','products']);
		$size = $request->input('size') ?: config('size.export', 1000);
		
		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		        $value['shop_name'] =  $value->shop->name;
		    }
		}, ['navigations.*']);
		return $this->export($data);
	}

	public function create()
	{
		$keys = 'name,sid,porder';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('navigation.store', $keys);
		return $this->view('admin.navigation.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,sid,porder';
		$data = $this->autoValidate($request, 'navigation.store', $keys);
		if(Navigation::where('sid',$data['sid'])->count()>config('site.navigation_max_cnt')){
		    return $this->failure('navigation.max_navigation_cnt',url('admin/navigation'));
		}else{
		   Navigation::create($data);
	   	   return $this->success('', url('admin/navigation'));
		}
	}

	public function edit($id)
	{
		$navigation = Navigation::find($id);
		if (empty($navigation))
			return $this->failure_noexists();

		$keys = 'name,sid,porder';
		$this->_validates = $this->getScriptValidate('navigation.store', $keys);
		$this->_data = $navigation;
		return $this->view('admin.navigation.edit');
	}

	public function update(Request $request, $id)
	{
		$navigation = Navigation::find($id);
		if (empty($navigation))
			return $this->failure_noexists();

		$keys = 'name,sid,porder';
		$data = $this->autoValidate($request, 'navigation.store', $keys, $navigation);
		$navigation->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$navigation = Navigation::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
