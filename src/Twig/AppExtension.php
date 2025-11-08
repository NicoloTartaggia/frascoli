<?php


namespace App\Twig;

use App\Helpers\GitUtils;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('cdate', [$this, 'commitDate']),
            new TwigFunction('cmsg', [$this, 'commitMsg']),
            new TwigFunction('cv', [$this, 'commit']),
            new TwigFunction('pversion', [$this, 'packageVersion']),
            new TwigFunction('countV', [$this, 'countVowels']),
            new TwigFunction('appversion', [$this, 'appVersion']),
        ];
    }


    public function countVowels($String) {
        return substr_count($String, 'a')+substr_count($String, 'e')+substr_count($String, 'i')+substr_count($String, 'o')+substr_count($String, 'u');
    }

    public function commitDate(){
        $git = new GitUtils();
        return $git->getLastCommitTime();
    }

    public function commitMsg(){
        $git = new GitUtils();
        return $git->getLastCommitMsg();
    }

    public function commit(){
        $git = new GitUtils();
        return $git->getLastCommit();
    }

    public function appVersion(){
        $git = new GitUtils();
        return $git->getAppV();
    }
}