<?php

namespace Tests\Feature;

use Tests\TestCase;
use Cloudinary\Cloudinary;

class CloudinaryConfigTest extends TestCase
{
    public function test_cloudinary_resolves_correctly_with_url(): void
    {
        // Mock the filesystems config disk for cloudinary to use a fake URL
        $fakeUrl = 'cloudinary://1234567890:abcdefghijklmnopqrstuvwxy@fakecloudname';
        config(['filesystems.disks.cloudinary.url' => $fakeUrl]);

        // Resolve Cloudinary from container
        $cloudinary = app(Cloudinary::class);

        $this->assertInstanceOf(Cloudinary::class, $cloudinary);

        // Verify config properties were parsed correctly from the URL by the SDK
        $this->assertEquals('fakecloudname', $cloudinary->configuration->cloud->cloudName);
        $this->assertEquals('1234567890', $cloudinary->configuration->cloud->apiKey);
        $this->assertEquals('abcdefghijklmnopqrstuvwxy', $cloudinary->configuration->cloud->apiSecret);
    }
}
