<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'type' => $this->type,
            'direction' => $this->direction,
            'text' => $this->getTextContent($this->phone_id, $this->to),
            'content' => $this->getContent($this->phone_id, $this->to),
            'timestamp' => $this->timestamp,
            'sended_by' => $this->sended_by,
        ];
    }

    private function getTextContent($phoneId, $to)
    {
        $body = json_decode($this->body);

        if ($this->type == 'text') {
            return $body->text->body;
        }

        return '';
    }

    private function getContent()
    {
        $body = json_decode($this->body);

        if ($this->type == 'image') {
            return [
                'url' => Url::to($body->image->url),
                'caption' => $body->image->caption ?? '',
            ];
        }
    }
}
