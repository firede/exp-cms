<?php
 defined('SYSPATH') or die('No direct access allowed.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Text extends Kohana_Text {
    /*****
     * 生成返回一个32位的UUID字串对象
     */
    public static function uuid() {
        $chars = md5(uniqid(mt_rand(), true));

        $uuid = substr($chars, 0, 8) . '-';

        $uuid .= substr($chars, 8, 4) . '-';

        $uuid .= substr($chars, 12, 4) . '-';

        $uuid .= substr($chars, 16, 4) . '-';

        $uuid .= substr($chars, 20, 12);

        return $uuid;
    }

}

?>
