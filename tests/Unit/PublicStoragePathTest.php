<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Evento;
use App\Models\Libro;
use App\Models\Noticias;
use App\Models\SlideBienvenida;
use App\Support\PublicStoragePath;
use Tests\TestCase;

class PublicStoragePathTest extends TestCase
{
    public function test_it_normalizes_legacy_and_public_disk_paths(): void
    {
        $this->assertSame('slides-bienvenida/slide.jpg', PublicStoragePath::normalize('storage/slides-bienvenida/slide.jpg'));
        $this->assertSame('eventos/evento.jpg', PublicStoragePath::normalize('eventos/evento.jpg'));
        $this->assertSame('portadas/libro.jpg', PublicStoragePath::normalize('public/portadas/libro.jpg'));
        $this->assertSame(
            asset('storage/slides-bienvenida/slide.jpg'),
            PublicStoragePath::url('storage/slides-bienvenida/slide.jpg')
        );
    }

    public function test_it_preserves_external_image_urls(): void
    {
        $this->assertSame('https://example.test/image.jpg', PublicStoragePath::url('https://example.test/image.jpg'));
        $this->assertNull(PublicStoragePath::normalize('https://example.test/image.jpg'));
    }

    public function test_image_accessors_build_urls_for_all_uploaded_image_types(): void
    {
        $slide = new SlideBienvenida(['imagen' => 'storage/slides-bienvenida/slide.jpg']);
        $event = new Evento(['imagen_url' => 'eventos/evento.jpg']);
        $book = new Libro(['portada_img' => 'storage/portadas/libro.jpg']);
        $news = new Noticias(['imagen_url' => 'https://example.test/news.jpg']);

        $this->assertSame(asset('storage/slides-bienvenida/slide.jpg'), $slide->imagen_public_url);
        $this->assertSame(asset('storage/eventos/evento.jpg'), $event->imagen_public_url);
        $this->assertSame(asset('storage/portadas/libro.jpg'), $book->portada_url);
        $this->assertSame('https://example.test/news.jpg', $news->imagen_public_url);
    }
}
