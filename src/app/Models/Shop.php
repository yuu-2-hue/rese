<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Aws\S3\S3Client;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'genre_id',
        'name',
        'overview',
        'image',
        'email',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favored()
    {
        return Favorite::where(['shop_id' => $this->id, 'user_id' => Auth::id()])->exists();
    }

    public function getFileUrl($filePath)
    {
        if (!$filePath) return null;

        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $filePath,
        ]);

        $request = $s3Client->createPresignedRequest($command, '+15 minutes');

        return (string) $request->getUri();
    }
}
