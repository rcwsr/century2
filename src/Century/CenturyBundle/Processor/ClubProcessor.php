<?php

namespace Century\CenturyBundle\Processor;

use Century\CenturyBundle\Document\User;

class ClubProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @param array $data
     * @return array
     */
    protected function persist(array $data)
    {
        foreach($data as $club){
            $this->user->addClub($club);
        }
        parent::persist($data);
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
