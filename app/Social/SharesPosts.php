<?php


namespace App\Social;


trait SharesPosts
{
    public function sharePosts($toShare)
    {
        $this->share = $toShare;
        $this->save();

        return $this->share;
    }
}