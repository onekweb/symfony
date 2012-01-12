<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2011 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Test\Filter;

use Assetic\Asset\FileAsset;
use Assetic\Filter\PngoutFilter;

/**
 * @group integration
 */
class PngoutFilterTest extends BaseImageFilterTest
{
    private $filter;

    protected function setUp()
    {
        if (!isset($_SERVER['PNGOUT_BIN'])) {
            $this->markTestSkipped('No pngout configuration.');
        }

        $this->filter = new PngoutFilter($_SERVER['PNGOUT_BIN']);
    }

    /**
     * @dataProvider getImages
     */
    public function testFilter($image)
    {
        $asset = new FileAsset($image);
        $asset->load();

        $before = $asset->getContent();
        $this->filter->filterDump($asset);

        $this->assertNotEmpty($asset->getContent(), '->filterLoad() sets content');
        $this->assertNotEquals($before, $asset->getContent(), '->filterLoad() changes the content');
        $this->assertMimeType('image/png', $asset->getContent(), '->filterLoad() creates PNG data');
    }

    public function getImages()
    {
        return array(
            array(__DIR__.'/fixtures/home.gif'),
            array(__DIR__.'/fixtures/home.jpg'),
            array(__DIR__.'/fixtures/home.png'),
        );
    }
}
