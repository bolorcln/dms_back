<?php

namespace App\Enum;

enum UserStatusEnum: string
{
  case ACTIVE = 'active';
  case INACTIVE = 'inactive';
}