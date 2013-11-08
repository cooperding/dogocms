<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsAction
 *
 * @author dingjicai
 */
class NewsAction extends BaseAction {

    //put your code here
    public function test()
    {
        $uid = guid();
        echo $uid;
        echo '<br/>';
        echo strlen($uid);
        echo '<br/>';
        echo sha1($uid);
    }

}
