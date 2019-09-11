<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class EpisodeController
 * @package App\Controller
 * @IsGranted("USER_ROLE_PLAYER")
 */
class EpisodeController
{

    /**
     *
     * @IsGranted("USER_ROLE_GM")
     */
    public function showAction ()
    {

    }

    /**
     *
     * @IsGranted("USER_ROLE_GM")
     */
    public function inviteAction ()
    {

    }

    /**
     *
     * @IsGranted("USER_ROLE_PLAYER")
     */
    public function statusAction ()
    {

    }

}