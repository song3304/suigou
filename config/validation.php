<?php

return [
	'member' => [
		'store' => [
			'username' => [
				'name' => '用户名',
				'rules' => 'required|ansi:2|unique:users,{{attribute}},{{id}}|regex:/^[a-z0-9\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}]*$/iu|max:150|min:3',
				'message' => [
					'regex' => '[:attribute] 必须为汉字、英文、数字',
				],
			],
			'nickname' => [
				'name' => '昵称',
				'rules' => 'string|min:1',
			],
			'realname' => [
				'name' => '真实姓名',
				'rules' => 'ansi:2|regex:/^[a-z\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}\s]*$/iu|max:50|min:3',
				'message' => [
					'regex' => '[:attribute] 必须为汉字、英文'
				],
			],
			'password' => [
				'name' => '密码',
				'rules' => 'required|min:6|confirmed',
			],
			'password_confirmation ' => [
				'name' => '确认密码',
				'rules' => 'required',
			],
			'gender' => [
				'name' => '性别',
				'rules' => 'required|not_zero|catalog:fields.gender',
			],
			'phone' => [
				'name' => '手机',
				'rules' => 'phone|unique:users,{{attribute}},{{id}}',
			],
			'idcard' => [
				'name' => '身份证',
				'rules' => 'idcard|unique:users,{{attribute}},{{id}}',
			],
			'email' => [
				'name' => 'E-Mail',
				'rules' => 'email|unique:users,{{attribute}},{{id}}',
			],
			'avatar_aid' => [
				'name' => '用户头像',
				'rules' => 'numeric',
			],
			'role_ids' => [
				'name' => '用户组',
				'rules' => 'required|array',
				'tag_name' => 'role_ids[]',
			],
			'accept_license' => [
				'name' => '阅读并同意协议',
				'rules' => 'accepted',
			]
		],
		'login' => [
			'username' => [
				'name' => '用户名',
				'rules' => 'required',
			],
			'password' => [
				'name' => '密码',
				'rules' => 'required',
			],
		]
	],
	'tag' => [
		'store' => [
			'keywords' => [
				'name' => '话题',
				'rules' => 'required|max:50',
			],
		],
	],
    'user-address'=>[
        'store' => [
            'uid'=>[
                'name' => '会员',
                'rules' => 'required|numeric',
            ],
            'receiver'=>[
                'name' => '收货人',
                'rules' => 'required',
            ],
            'phone'=>[
                'name' => '电话',
                'rules' => 'required|phone',
            ],
            'province'=>[
                'name' => '省',
                'rules' => 'required|numeric',
            ],
            'city'=>[
                'name' => '市',
                'rules' => 'required|numeric',
            ],
            'area'=>[
                'name' => '区',
                'rules' => 'required|numeric',
            ],
            'address'=>[
                 'name'=>'详细地址',
                 'rules' => 'required'  
            ],
            'postal_code'=>[
                'name' => '邮费',
                'rules' => 'required',
            ],
        ]
    ],
    'banner' => [
         'store' => [
            'title' => [
                'name' => '标题',
                'rules' => 'required'
             ],
             'url' => [
                'name' => '网址',
                'rules' => 'url|required_without:pid'
            ],
            'cover' => [
                'name' => '封面',
                'rules' => 'required'
            ],
            'nid' => [
                'name' => '位置',
                'rules' => 'numeric',
            ],
            'sid' => [
                'name' => '门店',
                'rules' => 'numeric',
            ],
            'pid' => [
                 'name' => '商品id',
                 'rules' => 'numeric|required_without:url',
             ],
            'porder' => [
                'name' => '排序',
                'rules' => 'numeric'
            ],
            'status' => [
                 'name' => '状态',
                 'rules' => 'required|bool'
            ]
         ]
    ],
    'shop' => [
        'store' => [
            'id' => [
                'name' => '指定用户',
                'rules' => 'required|numeric',
            ],
            'name' => [
                'name' => '门店名称',
                'rules' => 'required'
            ],
            'province'=>[
                'name' => '省',
                'rules' => 'required|numeric',
            ],
            'city'=>[
                'name' => '市',
                'rules' => 'required|numeric',
            ],
            'area'=>[
                'name' => '区',
                'rules' => 'required|numeric',
            ],
            'address'=>[
                 'name'=>'详细地址',
                 'rules' => 'required'  
            ],
            'phone'=>[
                'name' => '电话',
                'rules' => 'required|phone',
            ],
            'longitude'=>[
                'name'=>'经度',
                'rules' => 'required|numeric'
            ],
            'latitude'=>[
                'name' => '纬度',
                'rules' => 'required|numeric',
            ],
            'status' => [
                'name' => '状态',
                'rules' => 'required|bool'
            ]
        ]
    ],
    'navigation' => [
        'store'=>[
            'name' => [
                'name' => '导航栏名',
                'rules' => 'required'
            ],
            'sid' => [
                'name' => '门店',
                'rules' => 'numeric',
            ],
            'porder' => [
                'name' => '排序',
                'rules' => 'numeric'
            ],
        ]
    ],
    'navigation' => [
        'store' => [
            'name' => [
                'name' => '导航',
                'rules' => 'required',
            ],
            'mid' => [
                'name' => '美容院ID',
                'rules' => 'required|numeric',
            ],
            'porder' => [
                'name' => '排序',
                'rules' => 'numeric'
            ]
        ]
    ],
    'product' => [
        'store' => [
            'title' => [
                'name' => '名称',
                'rules' => 'required',
            ],
            'keywords' => [
                'name' => 'SEO关键字',
                'rules' => [],
            ],
            'description' => [
                'name' => 'SEO描述',
                'rules' => [],
            ],
            'content' => [
                'name' => '内容',
                'rules' => 'required',
            ],
            'cover_aids' => [
                'name' => '封面图片',
                'rules' => 'required|array',
            ],
            'express_price' => [
                'name' => '快递费/件',
                'rules' => 'required',
            ],
            'market_price' => [
                'name' => '市场价',
                'rules' => 'required|numeric|not_zero',
            ],
            'price' => [
                'name' => '优惠价',
                'rules' => 'required|numeric|not_zero',
            ],
            'count' => [
                'name' => '库存',
                'rules' => 'required|not_zero|numeric',
            ],
            'sid' => [
                'name' => '门店ID',
                'rules' => 'numeric',
            ],
            'nids' => [
                'name' => '导航',
                'rules' => 'required|array',
                'tag_name' => 'nids[]',
            ]           
        ],
    ],
    'shop-product' => [
        'store' => [
            'porder' => [
                'name' => '排序',
                'rules' => 'numeric'
            ]
        ]
    ],
    'product-attr-type' =>[
        'store'=>[
            'name'=>[
                'name' => '属性类名',
                'rules' => 'required',
            ],
        ]
    ],
    'product-attr' =>[
        'store'=>[
            'name'=>[
                'name' => '属性',
                'rules' => 'required',
            ],
        ]
    ],
];