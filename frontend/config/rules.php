<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 09.01.2020
 * Time: 21:29
 */

return [
    '<controller:[\w\-]+>' => '<controller>',
    '<controller:[\w\-]+>/<action:[\w\-]+>/<p:\d+>/<per:\d+>' => '<controller>/<action>',
    '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
    '<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
];