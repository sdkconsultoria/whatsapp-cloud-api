<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'name' => $this->name,
            'name' => $this->name,
            'content' => $this->getTemplateJson(),
        ];
    }

    private function getTemplateJson()
    {
        return json_decode($this->content)->components;
    }
}
