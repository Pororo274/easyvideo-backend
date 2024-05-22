<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage query()
 * @property int $id
 * @property string $uuid
 * @property string $width
 * @property string $height
 * @property string $crop_width
 * @property string $crop_height
 * @property string $x_position
 * @property string $y_position
 * @property string $media_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereCropHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereCropWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereMediaUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereXPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualImage whereYPosition($value)
 * @mixin \Eloquent
 */
class VirtualImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'width', 'height', 'crop_width', 'crop_height',
        'x_position', 'y_position', 'start_time', 'uuid', 'media_uuid'
    ];
}
