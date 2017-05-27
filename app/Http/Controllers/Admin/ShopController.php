<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop;
use Addons\Core\Controllers\ApiTrait;
use App\Role;
use DB;

class ShopController extends Controller
{
	use ApiTrait;
	//public $permissions = ['shop'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$shop = new Shop;
		$size = $request->input('size') ?: config('size.models.'.$shop->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.shop.list');
	}

	public function data(Request $request)
	{
		$shop = new Shop;
		$builder = $shop->newQuery()->with(['user']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['shop_status'] =  $value->status_tag();
		    }
		}, ['shops.*']);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$shop = new Shop;
		$builder = $shop->newQuery()->with(['user']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['shop_status'] =  $value->status_tag();
		    }
		}, ['shops.*']);
		return $this->export($data);
	}

	public function show(Request $request,$id)
	{
		$shop = Shop::with(['user'])->find($id);
		if (empty($shop))
			return $this->failure_noexists();

		$this->_data = $shop;
		return !$request->offsetExists('of') ? $this->view('admin.shop.show') : $this->api($shop->toArray());
	}

	public function create()
	{
		$keys = 'id,name,province,city,area,address,phone,longitude,latitude,status';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('shop.store', $keys);
		return $this->view('admin.shop.create');
	}

	public function store(Request $request)
	{
		$keys = 'id,name,province,city,area,address,phone,longitude,latitude,status';
		$data = $this->autoValidate($request, 'shop.store', $keys);

		$shop = Shop::create($data);
		if(!$shop->user->hasRole('shop')) $shop->user->attachRole(Role::findByName('shop'));
		return $this->success('', url('admin/shop'));
	}

	public function edit($id)
	{
		$shop = Shop::find($id);
		if (empty($shop))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone,longitude,latitude,status';
		$this->_validates = $this->getScriptValidate('shop.store', $keys);
		$this->_data = $shop;
		return $this->view('admin.shop.edit');
	}

	public function update(Request $request, $id)
	{
		$shop = Shop::find($id);
		if (empty($shop))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone,longitude,latitude,status';
		$data = $this->autoValidate($request, 'shop.store', $keys, $shop);
		$shop->update($data);
		if(!$shop->user->hasRole('shop')) $shop->user->attachRole(Role::findByName('shop'));
		return $this->success('', url('admin/shop/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$shop = Shop::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
