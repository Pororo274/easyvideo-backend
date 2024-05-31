<?php

namespace App\Models;

use App\Contracts\Observers\ProjectUpdatedContract;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Factories\FilterList\FilterListFactory;
use App\FFMpeg\Factories\Filters\FFMpegFilterFactory;
use App\Observers\ProjectUpdateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

/**
 * @property VirtualMediaTypeEnum $content_type
 * @property string $content
 * @property int $layer
 * @property string $uuid
 * @property array $filters
 * @property int $project_id
 */
#[ObservedBy([ProjectUpdateObserver::class])]
class VirtualMedia extends Model implements ProjectUpdatedContract
{
    use HasFactory;

    protected $fillable = [
        'content_type', 'project_id', 'content', 'layer', 'uuid', 'filters'
    ];

    protected $casts = [
        'content_type' => VirtualMediaTypeEnum::class,
        'filters' => 'array'
    ];

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getProjectId(): int
    {
        return $this->project_id;
    }

    public function toDto(): VirtualMediaDto
    {
        $dtoClass = $this->content_type->toDtoClass();
        $factories = collect(App::tagged($this->content_type->getTag()))->toArray();


        return app($dtoClass, [
            'contentType' => $this->content_type,
            'content' => $this->content,
            'filterList' => (new FilterListFactory(...$factories))->createFromArray($this->filters),
            'layer' => $this->layer,
            'projectId' => $this->project_id,
            'uuid' => $this->uuid,
        ]);
    }
}
