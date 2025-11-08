<?php
/**
 * Created by PhpStorm.
 * User: ux
 * Date: 21/03/2020
 * Time: 10:03
 */

namespace App\Helpers;


class GitUtils{

    public function __construct() {

    }

    public function getLastCommitTime() {
        date_default_timezone_set("Europe/Rome");
        exec("git log --pretty=\"%ci\" -n1 HEAD", $output);
        $dateTime = strtotime($output[0]);
        return date('d/m/y H:i', $dateTime);
    }

    public function getLastCommitMsg() {
        exec("git log -1 --pretty=\"%B\" ", $output);
        if (!$output) {
            return "no commit data";
        }
        return $output[0];
    }

    public function getLastCommit() {
        exec("git log -1 --pretty=\"%h\" ", $output);
        if (!$output) {
            return "000000";
        }
        return $output[0];
    }


    public function getAppV() {
        return "v1.3.18";
    }

}
