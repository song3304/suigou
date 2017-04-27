<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Addons\Core\Controllers\ApiTrait;
use DB;
use App\UserAddress;

class UserAddressController extends Controller
{
	use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$address = new UserAddress;
		$pagesize = $request->input('pagesize') ?: config('size.models.'.$address->getTable(), config('size.common'));

		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request);
        $this->_queries = $this->_getQueries($request);
		return $this->view('admin.user_address.list');
	}

	public function data(Request $request)
	{
		$address = new UserAddress;
		$builder = $address->newQuery()->with(['user']);
		
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, null);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$address = new UserAddress;
		$builder = $address->newQuery()->with(['user']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder, function(&$v){
		    $v['username'] = !empty($v['user_id']) ? $v['user']['username'] : NULL;
		}, ['user_addresses.*']);
		return $this->export($data);
	}

	public function show(Request $request, $id)
	{
		$address = UserAddress::with(['user'])->find($id);
		if (empty($address))
			return $this->failure_noexists();

		$this->_data = $address;
		return !$request->offsetExists('of') ? $this->view('admin.user_address.show') : $this->api($address->toArray());
	}

	public function create()
	{
		$keys = 'uid,receiver,phone,province,city,area,address,postal_code';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('user-address.store', $keys);
		return $this->view('admin.user_address.create');
	}

	public function store(Request $request)
	{
		$keys = 'uid,receiver,phone,province,city,area,address,postal_code';
	    $data = $this->autoValidate($request, 'user-address.store', $keys);

		$address = UserAddress::create($data);
		return $this->success('', url('admin/user_address'));
	}

	public function edit($id)
	{
		$address = UserAddress::find($id);
		if (empty($address))
			return $this->failure_noexists();

        $keys = 'uid,receiver,phone,province,city,area,address,postal_code';
		$this->_validates = $this->getScriptValidate('user-address.store', $keys);
		$this->_data = $address;
		return $this->view('admin.user_address.edit');
	}

	public function update(Request $request, $id)
	{
		$address = UserAddress::find($id);
		if (empty($address))
			return $this->failure_noexists();

        $keys = 'uid,receiver,phone,province,city,area,address,postal_code';
		$data = $this->autoValidate($request, 'user-address.store', $keys, $address);
		
		$address->update($data);
		return $this->success();
	}

	public function destroy(Request $request,$id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$addressClass = UserAddress::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
