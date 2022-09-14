<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Header;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Header\Header;
use Sdkconsultoria\WhatsappCloudApi\Services\ResumableUploadAPI;

class MediaHeader extends Header
{
    private $media;

    function __construct(string $file) {
        $this->setMedia($file);
        $this->loadFormat();
        parent::__construct();
    }

    public function loadFormat(): void
    {
        $mime_type = explode('/', $this->media->mime_type);

        switch ($mime_type[0]) {
            case 'image':
                $this->format = self::FORMAT_IMAGE;
                break;
            case 'video':
                $this->format = self::FORMAT_VIDEO;
                break;
            default:
                $this->format = self::FORMAT_DOCUMENT;
                break;
        }
    }

    public function validate(): void
    {

    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'format' => $this->format,
            'example' => ["header_handle" => [$this->media->handler]],
        ];
    }

    public function setMedia(string $file ): void
    {
        $this->media = ResumableUploadAPI::uploadFile($file);
    }
}
