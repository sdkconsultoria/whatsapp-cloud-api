<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'timestamp' => $this->timestamp,
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
}
