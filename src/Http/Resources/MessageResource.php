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
            'content' => $this->getContent(),
            'timestamp' => $this->timestamp,
            'sended_by' => $this->sended_by,
            'reaction' => $this->reaction,
            'sent_at' => $this->sent_at,
            'read_at' => $this->read_at,
            'delivered_at' => $this->delivered_at,
            'response_to' => $this->getResponseTo(),
        ];
    }

    private function getContent()
    {
        $body = json_decode($this->body);

        switch ($this->type) {
            case 'image':
            case 'video':
            case 'audio':
            case 'sticker':
            case 'document':
                return [
                    'url' => Url::to($body->{$this->type}->url ?? ''),
                    'caption' => $body->{$this->type}->caption ?? '',
                ];
            case 'contacts':
                return $body->contacts;
            case 'text':
                return $body->text->body;
            case 'template':
                return $body;
        }
    }

    private function getResponseTo()
    {
        $body = json_decode($this->body);

        if ($body->context ?? false) {
            return $body->context;
        }

        return null;
    }
}
