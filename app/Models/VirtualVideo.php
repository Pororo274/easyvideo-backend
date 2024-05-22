<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo query()
 * @property int $id
 * @property string $uuid
 * @property string $original_duration
 * @property string $width
 * @property string $height
 * @property string $crop_width
 * @property string $crop_height
 * @property string $x_position
 * @property string $y_position
 * @property string $media_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereCropHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereCropWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereMediaUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereOriginalDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereXPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualVideo whereYPosition($value)
 * @mixin \Eloquent
 */
class VirtualVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_duration', 'width', 'height', 'crop_width', 'crop_height',
        'x_position', 'y_position', 'uuid', 'media_uuid'
    ];
}
