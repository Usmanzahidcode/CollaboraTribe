<?php

namespace App\Enums\Project;

enum ProjectStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case COMPLETE = 'complete';
    case ABORTED = 'aborted';
}
