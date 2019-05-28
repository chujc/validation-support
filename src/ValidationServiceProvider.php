<?php

namespace ChuJC\Validation;

use ChuJC\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        foreach (Validate::getRegex() as $item=>$regex) {
            Validator::extend($item, function($attribute, $value) use ($item) {
                return Validate::$item($value);
            }, Validate::$message[$item]);
        }

        Validator::extend('id_card', function($attribute, $value) {
            return Validate::id_card($value);
        }, ':attribute只能是身份证号码');

        Validator::extend('back_card', function($attribute, $value) {
            return Validate::back_card($value);
        }, ':attribute只能是银行卡号');

        Validator::extend('password', function($attribute, $value, $parameters) {
            $mode = 1;
            if (array_key_exists(0, $parameters)) {
                $mode = intval($parameters[0]);
            }
            return Validate::password($value, $mode);
        });

        Validator::replacer('password', function($message, $attribute, $rule, $parameters) {
            if (strpos($message, 'validation') === false) {
                return $message;
            }
            $mode = 1;
            if (array_key_exists(0, $parameters)) {
                $mode = intval($parameters[0]);
            }
            return str_replace(':attribute', $attribute, Password::$message[$mode]);
        });



    }
}
