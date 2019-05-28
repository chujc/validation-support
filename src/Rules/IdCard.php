<?php

namespace ChuJC\Validation\Rules;


class IdCard
{

    /**
     * 地区编码
     * @var array
     */
    private static $area= [
        11 => '北京',
        12 => '天津',
        13 => '河北',
        14 => '山西',
        15 => '内蒙古',
        21 => '辽宁',
        22 => '吉林',
        23 => '黑龙江',
        31 => '上海',
        32 => '江苏',
        33 => '浙江',
        34 => '安徽',
        35 => '福建',
        36 => '江西',
        37 => '山东',
        41 => '河南',
        42 => '湖北',
        43 => '湖南',
        44 => '广东',
        45 => '广西',
        46 => '海南',
        50 => '重庆',
        51 => '四川',
        52 => '贵州',
        53 => '云南',
        54 => '西藏',
        61 => '陕西',
        62 => '甘肃',
        63 => '青海',
        64 => '宁夏',
        65 => '新疆',
        81 => '香港',
        82 => '澳门',
        83 => '台湾'
    ];

    /**
     * 校验码
     * @var array
     */
    private static $checkCode = [
        1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2
    ];

    /**
     * 检测中国的身份证格式与港澳台居民居住证是否正确
     * @param $idCard
     * @return bool
     */
    public static function check($idCard)
    {

        //6位：地区码：[1-9]{1}\d{5}
        //4位：年：[19|20]{2}\d{2}   表示1900-2099
        //2位：月份：((0[1-9])|(10|11|12))
        //2位：天数：(([0-2][1-9])|10|20|30|31)
        //3位：随机码：\d{3}
        //1位：校验码：[0-9xX]{1}
        if (!preg_match('/^[1-6|8]{1}\d{5}[19|20]{2}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9xX]{1}$/', $idCard)) {

            return false;
        }

        //校验地区是否正确
        if (!static::$area[substr($idCard, 0, 2)]) {

            return false;
        }

        //前面不能校验闰年问题
        if (!checkdate(substr($idCard, 10, 2), substr($idCard, 12, 2), substr($idCard,6, 4))) {

            return false;
        }


        $sum = 0;

        for($i = 17; $i > 0; $i--){

            $s = pow(2, $i) % 11;

            $sum += $s * $idCard[17-$i];

        }

        //校验校验码是否正确
        if (static::$checkCode[$sum % 11] == $idCard[17]) {

            return true;
        }

        return false;
    }

}