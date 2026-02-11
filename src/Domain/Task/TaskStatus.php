<?php

namespace App\Domain\Task;

enum TaskStatus: string
{
    case TO_DO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';
}
