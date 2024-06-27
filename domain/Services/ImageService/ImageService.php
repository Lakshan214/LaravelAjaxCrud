<?php

namespace domain\Services\ImageService;

use App\Models\Images;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $image;

    public function __construct()
    {
        $this->image = new Images();
    }

    public function store($image,$prescription_id): Images
    {
        if (isset($image)) {
            $filePath = Storage::disk('do')->putFile(config('filesystems.disks.do.folder'), $image, 'public');
            $data['path'] = config('filesystems.disks.do.public_url').'/'.$filePath;
            $data['prescription_id'] = $prescription_id;

            return $this->image->create($data);
        }
    }

    public function get($prescription_id)
    {
        return $this->image->where('prescription_id', $prescription_id)->get();

    }



}
