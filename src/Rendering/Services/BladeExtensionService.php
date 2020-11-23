<?php

namespace Softworx\RocXolid\CMS\Rendering\Services;

use Log;
// rocXolid rendering contracts
use Softworx\RocXolid\Rendering\Contracts\Renderable;
// rocXolid cms elements services
use Softworx\RocXolid\CMS\Elements\Services\ContentCompiler;

/**
 * Retrieves themed view for given object and view name.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class BladeExtensionService
{
    /**
     * Compile Blade directive.
     *
     * @param string $method
     * @param string $args
     * @return string
     */
    public static function compile(string $method, string $args): string
    {
        return sprintf(
            "<?php %s::%s(%s); ?>",
            static::class,
            $method,
            sprintf('$component, %s', $args)
        );
    }

    /**
     * Blade directive extension to render editable area for CMS Elements.
     *
     * @param \Softworx\RocXolid\Rendering\Contracts\Renderable $component
     * @param string|null $content_part_name
     * @param array|null $content_part_assignments
     * @param string|null $default_view_name
     * @param array|null $default_view_assignments
     */
    public static function editable(
        Renderable $component,
        ?string $content_part_name = null,
        ?array $content_part_assignments = [],
        ?string $default_view_name = null,
        ?array $default_view_assignments = []
    ) {
        echo $component->render('editable', [
            'content_part_name' => $content_part_name,
            'content_part_assignments' => $content_part_assignments,
            'default_view_name' => $default_view_name,
            'default_view_assignments' => $default_view_assignments,
        ]);
    }

    /**
     * Blade directive extension to render content area for CMS Elements.
     *
     * @param \Softworx\RocXolid\Rendering\Contracts\Renderable $component
     * @param string|null $content_part_name
     * @param array|null $content_part_assignments
     * @param string|null $default_view_name
     * @param array|null $default_view_assignments
     */
    public static function elementContent(
        Renderable $component,
        ?string $content_part_name = null,
        ?array $content_part_assignments = [],
        ?string $default_view_name = null,
        ?array $default_view_assignments = []
    ) {
        $element = $component->getModel();

        if ($element->isSetContent($content_part_name)) {

            // Return the compiled content (part) if it is available.

            $content = $element->getContent($content_part_name);

            try {
                $content = ContentCompiler::init($element)->process($content, collect($content_part_assignments));
            } catch (\Exception $e) {
                $content = printf('<p style="color: red; background: yellow;">!! %s !!</p>', $e->getMessage());

                Log::error($e);
            }
        } elseif ($element->useDefaultContent($content_part_name)) {

            // Used for newly added elements in document composition
            // or when the element content template was changed over time
            // and the element contains old-structured (incomplete) content.

            try {
                $content = $default_view_name
                        ? $component->render($default_view_name, array_merge([ 'content_part_name' => $content_part_name ], $default_view_assignments))
                        : $element->getDefaultContent($content_part_name);
            } catch (\Exception $e) {
                $content = sprintf('<p style="color: red; background: yellow;">!! %s !!</p>', $e->getMessage());

                Log::error($e);
            }
        } else {

            // If the content is not available (set) and the rendering
            // happens outside document composition.

            $content = null;
        }

        echo $content;
    }

    /**
     * Blade directive extension to render placeholder item for CMS Elements.
     *
     * @param \Softworx\RocXolid\Rendering\Contracts\Renderable $component
     * @param string $dependency
     * @param string $title
     * @param boolean $remove
     */
    public static function placeholder(
        Renderable $component,
        string $dependency,
        string $title,
        bool $remove = false,
        ?array $assignments = []
    ) {
        $element = $component->getModel();

        $content = (string)$component->render('placeholder', [
            'dependency' => $dependency,
            'title' => $component->translate(sprintf('placeholder.%s', $title)),
            'remove' => $remove,
        ]);

        try {
            echo ContentCompiler::init($element)->process($content, collect($assignments));
        } catch (\Exception $e) {
            echo printf('<p style="color: red; background: yellow;">!! %s !!</p>', $e->getMessage());
        }
    }
}
