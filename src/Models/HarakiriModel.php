<?php
declare(strict_types=1);

namespace Harakiri\Models;

use Harakiri\Repository\Traits\ModelExtraTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HarakiriModel
 * @package harakiri_repository_pattern\Repository\Models
 */
class HarakiriModel extends Model
{
    use ModelExtraTrait;
}
