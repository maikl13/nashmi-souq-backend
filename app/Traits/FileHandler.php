<?php

namespace App\Traits;

use Image;
use Storage;

trait FileHandler
{
    protected static $sizes = ['xxxs', 'xxs', 'xs', 's', '', 'l', 'xl', 'xxl', 'xxxl', 'o'];

    public function upload_file($file, $field, $options)
    {
        if (! $file) {
            return false;
        }
        if (property_exists($this, $field) && $this->$field) {
            $this->delete_file($field);
        }
        $this->$field = $this->upload($file, $options);

        return $this->save() ? $this->$field : false;
    }

    public function upload_files($files, $field, $options)
    {
        if (! $files) {
            return false;
        }
        $images = isset($this->attributes[$field]) && is_array(json_decode($this->$field)) ? json_decode($this->$field) : [];
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                if ($filename = $this->upload($file, $options)) {
                    $images[] = $filename;
                }
            }
        }

        $this->$field = json_encode($images);

        return $this->save() ? $this->$field : false;
    }

    public function upload($file, $options = [])
    {
        if (! $file) {
            return null;
        }
        $original_extension = $file->extension();
        $path = $options['path'] ?? $this->path();
        $disk = $this->disk();
        $ext = $options['ext'] ?? $original_extension;
        $w = $options['w'] ?? null;
        $h = $options['h'] ?? null;
        $allowed = $options['allowed'] ?? null;
        $sizes = $options['sizes'] ?? self::get_sizes(['w' => $w, 'h' => $h, 'allowed' => $allowed]);

        if (substr($file->getMimeType(), 0, 5) == 'image' && $file->getClientOriginalExtension() != 'gif') {
            $disk->exists($path) or $disk->makeDirectory($path, 0755, true);
            $uid = uid();

            foreach ($sizes as $prefix => $size) {
                $image = Image::make($file);
                if ($size['w'] || $size['h']) {
                    if ($size['w'] && $size['h']) {
                        $image = $image->resize($size['w'], $size['h']);
                    } else {
                        $image = $image->resize($size['w'], $size['h'], function ($c) {
                            $c->aspectRatio();
                        });
                    }
                }

                if ($prefix != 'o') {
                    try {
                        if (isset($options['watermark']) && $options['watermark']) {
                            $watermark = Image::make(public_path(setting('footer_logo')));
                            $height = round(($image->height() + $image->width()) / 25);
                            $width = null;
                            $padding = $image->height() < $image->width() ? round($image->height() / 30) : round($image->width() / 30);
                            $watermark = $watermark->resize($width, $height, function ($c) {
                            $c->aspectRatio();
                            })->opacity(55);
                            $image->insert($watermark, 'bottom-right', $padding, $padding);
                        }
                    } catch (\Throwable $th) {/*_*/
                    }
                }

                foreach (['webp', $ext] as $extension) {
                    $filename = $prefix.$uid.'.'.$extension;
                    $image_contents = $image->stream()->__toString();

                    if (! $disk->put($path.$filename, $image_contents)) {
                        return null;
                    }
                }
            }

            return $uid.'.'.$ext;
        } else {
            $filename = uid().'.'.$original_extension;

            return $disk->putFileAs($path, $file, $filename) ? $filename : null;
        }
    }

    public function encode($filename, $options = [])
    {
        // To encode old files before multi-size process programming
        // this should be one-time-use function
        if (! $filename) {
            return null;
        }
        $path = $options['path'] ?? $this->path();
        $disk = $this->disk();
        $ext = $options['ext'] ?? 'jpg';
        $w = $options['w'] ?? null;
        $h = $options['h'] ?? null;
        $allowed = $options['allowed'] ?? null;
        $sizes = $options['sizes'] ?? self::get_sizes(['w' => $w, 'h' => $h, 'allowed' => $allowed]);

        $disk->exists($path) or $disk->makeDirectory($path, 0755, true);
        foreach ($sizes as $prefix => $size) {
            $newfilename = $prefix.$filename;
            if ((! empty($prefix) && $disk->exists($path.$newfilename)) || (empty($prefix) && $disk->exists($path.'xs'.$filename))) {
                continue;
            }

            $image = Image::make($this->disk()->path($path.'/'.$filename));
            if ($size['w'] || $size['h']) {
                if ($size['w'] && $size['h']) {
                    $image = $image->resize($size['w'], $size['h']);
                } else {
                    $image = $image->resize($size['w'], $size['h'], function ($c) {
                        $c->aspectRatio();
                    });
                }
            }

            if ($prefix != 'o') {
                if (isset($options['watermark']) && $options['watermark']) {
                    $watermark = Image::make(public_path(setting('footer_logo')));
                    $height = round(($image->height() + $image->width()) / 25);
                    $width = null;
                    $padding = $image->height() < $image->width() ? round($image->height() / 30) : round($image->width() / 30);
                    $watermark = $watermark->resize($width, $height, function ($c) {
                    $c->aspectRatio();
                    })->opacity(55);
                    $image->insert($watermark, 'bottom-right', $padding, $padding);
                }
            }

            foreach (['webp', $ext] as $extension) {
                $image_contents = $image->stream()->__toString();

                if (! $disk->put($path.$newfilename, $image_contents)) {
                    return null;
                }
            }
        }

        return $filename;
    }

    public function delete_file($field_name, $image = false)
    {
        $file_name = $image ? $image : $this->$field_name;
        if (empty($file_name)) {
            return;
        }
        $disk = $this->disk();
        $path = $this->path();

        foreach (self::$sizes as $prefix) {
            $file = $path.$prefix.$file_name;
            $file_webp = $path.$prefix.pathinfo($file_name, PATHINFO_FILENAME).'.webp';

            if (($disk->exists($file) && ! $disk->delete($file)) || ($disk->exists($file_webp) && ! $disk->delete($file_webp))) {
                return false;
            }
        }
        $this->delete_folder_if_empty();

        if ($image) {
            $images = json_decode($this->$field_name);
            $key = array_search($image, $images);
            unset($images[$key]);
            $this->$field_name = json_encode(array_values($images));
        } else {
            $this->$field_name = null;
        }

        return $this->save() ? true : false;
    }

    public function delete_folder_if_empty()
    {
        $disk = $this->disk();
        $path = $this->path();
        if ($disk->exists($path) && ! count($disk->allFiles($path)) && ! count($disk->allDirectories($path))) {
            $disk->deleteDirectory($path);
        }
    }

    protected function path()
    {
        return strtolower(substr(strrchr(__CLASS__, '\\'), 1)).'/'.$this->id.'/';
    }

    protected static function get_sizes($options = [])
    {
        $w = $options['w'] ?? 1280;
        $h = $options['h'] ?? null;
        $allowed = $options['allowed'] ?? self::$sizes;

        $sizes = [];

        if (in_array('o', $allowed)) {
            $sizes['o'] = ['w' => null, 'h' => null, 'quality' => 100];
        }
        if (in_array('xxxl', $allowed)) {
            $sizes['xxxl'] = ['w' => $w ? $w * 4 : null, 'h' => $h ? $h * 4 : null, 'quality' => 100];
        }
        if (in_array('xxl', $allowed)) {
            $sizes['xxl'] = ['w' => $w ? $w * 3 : null, 'h' => $h ? $h * 3 : null, 'quality' => 100];
        }
        if (in_array('xl', $allowed)) {
            $sizes['xl'] = ['w' => $w ? $w * 2 : null, 'h' => $h ? $h * 2 : null, 'quality' => 90];
        }
        if (in_array('l', $allowed)) {
            $sizes['l'] = ['w' => $w ? $w * 1.5 : null, 'h' => $h ? $h * 1.5 : null, 'quality' => 70];
        }
        if (in_array('', $allowed)) {
            $sizes[''] = ['w' => $w ? $w : null, 'h' => $h ? $h : null, 'quality' => 75];
        }
        if (in_array('s', $allowed)) {
            $sizes['s'] = ['w' => $w ? $w * .5 : null, 'h' => $h ? $h * .5 : null, 'quality' => 70];
        }
        if (in_array('xs', $allowed)) {
            $sizes['xs'] = ['w' => $w ? $w * .25 : null, 'h' => $h ? $h * .25 : null, 'quality' => 60];
        }
        if (in_array('xxs', $allowed)) {
            $sizes['xxs'] = ['w' => $w ? $w * .1 : null, 'h' => $h ? $h * .1 : null, 'quality' => 60];
        }
        if (in_array('xxxs', $allowed)) {
            $sizes['xxxs'] = ['w' => $w ? $w * .05 : null, 'h' => $h ? $h * .05 : null, 'quality' => 50];
        }

        return $sizes;
    }

    public function images($images, $options)
    {
        $size = $options['size'] ?? '';
        $default = $options['default'] ?? 'general';
        $default = '/assets/images/defaults/'.$default.'/'.$size.'default.png';
        $images = json_decode($images);
        $imgs = [];
        if (is_array($images) && count($images)) {
            foreach ($images as $image) {
                $imgs[] = $this->image($image, $options);
            }
        }

        return ! empty($imgs) ? $imgs : [$default];
    }

    public function image($image, $options)
    {
        $size = $options['size'] ?? '';
        $return_default = $options['return_default'] ?? false;
        $return_default = $options['return_default'] ?? false;
        $default = $options['default'] ?? 'general';
        $default = '/assets/images/defaults/'.$default.'/'.$size.'default.png';
        $disk = $this->disk();

        if (! $image) {
            return $default;
        }

        $sizes = self::$sizes;
        // Move required size to top and the most sizes near to it will follow
        $k = array_search($size, $sizes);
        uksort($sizes, function ($a, $b) use ($k) {
            return (7 - abs($a - $k)) > (7 - abs($b - $k)) ? 0 : 1;
        });

        $path = $this->path();

        if ($return_default) {
            return $default;
        }

        if (pathinfo($image, PATHINFO_FILENAME) == 'gif') {
            return $disk->url($path.$image);
        } else {
            foreach ($sizes as $size) {
                $img = $path.$size.$image;
                if (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'] ?? '', ' Chrome/') !== false) {
                    $webp_img = str_replace('.png', '.webp', $img);
                    $webp_img = str_replace('.jpg', '.webp', $img);
                    if ($disk->exists($webp_img)) {
                        return $disk->url($webp_img);
                    }
                }
                if ($disk->exists($img)) {
                    return $disk->url($img);
                }
            }
        }

        return $default;
    }

    public function disk()
    {
        return Storage::disk('public');
    }
}
