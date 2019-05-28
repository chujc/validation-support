<h1 align="center"> validation-support </h1>

<p align="center"> Lumen 与 laravel 表单验证规则扩展 (其他框架也可以使用)</p>


## 安装
```bash
composer require chujc/validation-support
```
laravel5.5以上版本自动注册

lumen在`bootstrap/app.php` 文件下面 取消如下代码的注释
```php
// $app->withFacades();
```
让后添加注册`ServiceProvider`
```php

$app->register(ChuJC\Validation\ValidationServiceProvider::class);

```

## 验证规则
- 中文
- 中文 + 字母表
- 中文 + 字母表 + 数字
- 中文 + 字母表 + 数字 + `_-`符号
- 🇨🇳手机号
- 🇨🇳身份证
- 银行卡
- 密码强度验证（不包含长度验证，长度可以先使用string|min:6|max:20 在使用password）

## Laravel / Lumen 使用
```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

...
    public function test(Request $request)
    {
        $params = $request->all();
    
        $validator = Validator::make($params, [
            'id' => 'required|id_card',
            'mobile' => 'required|mobile',
            'back_card' => 'required|back_card',
            'name' => 'required|chs',
            'password' => 'required|string|min:6|max:20|password:2', //使用密码强度2级
        ], [
            'id.*' => '请输入正确的身份证号码',
            'mobile.*' => '请输入正确的手机号码',
            'back_card.*' => '请输入正确的银行卡号',
            'name.*' => '请输入正确中文姓名',
            'password.required' => '请输入密码',
            'password.password' => '密码必须包含数字、小写字母、大写字母',
            'password.*' => '密码长度最短6位,最长20位',
        ]);
    
        if ($validator->fails()) {
            dump($validator->errors());
        }
    }
...
```

## 其他使用方法

```php
use ChuJC\Validation\Validate;

Validate::chs('测试'); // 只能是汉字
Validate::chs_alpha('测试A'); // 只能是汉字、字母
Validate::chs_alpha_num('测试A1'); // 只能是汉字、字母和数字
Validate::chs_dash('测试A1_-'); // 只能是汉字、字母、数字和下划线_及破折号-
Validate::mobile('1303236xxxx'); // 🇨🇳手机号规则 避免隐私泄露 请自行测试
Validate::id_card('513030199909090009'); // 🇨🇳身份证号规则 避免隐私泄露 请自行测试
Validate::back_card('6223910712279064'); // 银行卡 避免隐私泄露 请自行测试
/**
 * 密码强度验证等级：默认1级
 * 0级 纯数字 6位 特殊场景（二级密码，支付密码等）使用
 * 1级 必须包含数字、字母（不区分大小写）默认
 * 2级 必须包含数字、大小写字母
 * 3级 必须包含数字、大小写字母、特殊符号
 */
Validate::password('chu111');
```

## 后续版本约定
- v.vv.vvv
  > v 表述大版本号，重大更新修改。vv 小版本号，用于新增验证规则。vvv修复版本号，用户描述，bug等修改
- 新规则
  > 如果有需要的新规则大家给发邮件到 john1668@qq.com
