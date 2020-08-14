<?php

namespace App\Entity;

class Sprint
{
    protected $users;

    protected $storyPointsAtBeginning;
    protected $storyPointsAtEnd;

    protected $scopeChange;

    //TODO: Implement sprint object to keep information organized
    // This should have the possibility to show SP per user at the beginning of the sprint and at the end
    // This also should show all possible scope change and calculate percents of completion
}
