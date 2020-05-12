<?php

namespace Softworx\RocXolid\CMS\Rendering\Services;

use Illuminate\Support\Facades\Blade;

use Softworx\RocXolid\Rendering\Services\RenderingService;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Retrieves themed view for given object and view name.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 * @todo: kinda quick'n'dirty
 */
class ThemeRenderingService extends RenderingService
{
    public static function renderContent(Element $element, string $content): string
    {
        if (!$element->getDependenciesDataProvider()->isReady()) {
            return $content;
        }

        $content = static::parseContent($element, $content);

        $assignments = collect();

        $dependencies = $element->getDependenciesProvider()->provideDependencies();

        $dependencies->each(function ($elementable_dependency) use ($element, $assignments) {
            $elementable_dependency->setAssignment($assignments, $element->getDependenciesDataProvider());
        });

        $content = static::render($content, $assignments->all());

        return $content;
    }

    protected static function parseContent(Element $element, string $content): string
    {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($doc->getElementsByTagName('span') as $span) {
            if ($span->hasAttribute('data-dependency')) {
                $dependency = $span->getAttribute('data-dependency');
                // $dependency = '';
                $dependency = str_replace('[[', '{!!', $dependency);
                $dependency = str_replace(']]', '!!}', $dependency);
                $dependency = str_replace('-&gt;', '->', $dependency);

                $span->parentNode->replaceChild($doc->createTextNode($dependency), $span);
            }
        }

        $content = $doc->saveHTML($doc->documentElement);
        $content = htmlspecialchars_decode($content);

        return $content;
    }
}
