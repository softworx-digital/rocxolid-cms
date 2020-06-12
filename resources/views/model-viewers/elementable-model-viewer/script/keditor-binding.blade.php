@push('script')
@foreach($component->getModel()->getStyles() as $path)
<style href="{{ asset($path) }}" data-type="keditor-style"></style>
@endforeach

<script type="text/javascript" data-keditor="script">
$(document).ready(function($)
{
    const makeElement = function($node, onlyData)
    {
        let element = {
            pivotData: {
                position: 0,
                template: 'default'
            },
            elementData: {
            },
            children: []
        };

        for (let i in $node.data()) {
            // put only defined data, or all if not defined
            if (!onlyData.length || onlyData.includes(i)) {
                element[i] = $node.data(i);
            }
        }

        return element;
    };

    const serialize = function($node, parent, onlyData = [], onNodeCreated)
    {
        if (!$node.find('[data-element-type]').length && !$node.is('[data-element-type]')) {
            return;
        }

        if ((parent === null) || $node.is('[data-element-type]')) {
            var element = makeElement($node, onlyData);

            console.log('Created element', element);
        }

        $node.children().each(function() {
            console.log('Child node [' + $(this).data('elementType') + '][' + $(this).data('elementId') + ']', $(this).get(0));

            let to = element || parent;
            let child = serialize($(this), to, onlyData, onNodeCreated);

            if (child) {
                child.pivotData.position = to.children.length;

                console.log('Adding to [' + to.elementType + '][' + (to.elementId || '-') + '] child [' + child.elementType + '][' + (child.elementId || '-') + '][pos: ' + child.pivotData.position + ']');

                to.children.push(child);
            }
        });

        if (element && (typeof onNodeCreated == 'function')) {
            element = onNodeCreated($node, element);
        }

        return element;
    };

    const parseNodeContent = function($node, element)
    {
        if ($node.is('[data-element-type="grid-column"]')) {
            if (typeof $node.attr('class') == 'string') {
                element.elementData.gridLayout = {};

                let colAttrs = $node.attr('class').split(' ').forEach(function (className) {
                    if (col = className.match(/\bcol-(\w+)-(\d+)/)) {
                        element.elementData.gridLayout[col[1]] = col[2];
                    }
                });
            }
        }

        if ($node.is('.content-container')) {
            let isSingleEditable = ($node.find('.editable-content').length === 1);

            if (isSingleEditable && !$node.find('.editable-content').data('name')) {
                element.elementData.content = $.trim($node.find('.editable-content').html());
            } else {
                element.elementData.content = {};

                $node.find('.editable-content').each(function() {
                    element.elementData.content[$(this).data('name')] = $(this).html();
                })
            }
        }

        return element;
    };

    const elementableApi = {
        previewComposition: function($element, composition) {
            window.rxUtility().ajaxCall({
                rx: window.rx(),
                element: $element,
                type: 'post',
                url: $element.data('preview-pdf-url'),
                data: {
                    composition: composition
                }
            });
        },
        storeComposition: function($element, composition) {
            window.rxUtility().ajaxCall({
                rx: window.rx(),
                element: $element,
                type: 'post',
                url: $element.data('update-url'),
                data: {
                    composition: composition
                }
            });
        },
        deleteComponent: function($element, component) {
            window.rxUtility().ajaxCall({
                rx: window.rx(),
                element: $element,
                type: 'delete',
                url: $element.data('element-destroy-url'),
                data: {
                    // @todo: ugly access method
                    elementType: $(component[0].innerHTML).find('[data-element-type]').first().data('elementType'),
                    elementId: $(component[0].innerHTML).find('[data-element-type]').first().data('elementId'),
                }
            });
        },
    };

    const locale = {
        viewOnMobile: 'Zobraziť mobilnú verziu',
        viewOnTablet: 'Zobraziť tabletovú verziu',
        viewOnLaptop: 'Zobraziť laptopovú verziu',
        viewOnDesktop: 'Zobraziť desktopovú verziu',
        previewOn: 'Náhľad zapnutý',
        previewOff: 'Náhľad vypnutý',
        fullscreenOn: 'Zobrazenie na celú obrazovku zapnuté',
        fullscreenOff: 'Zobrazenie na celú obrazovku vypnuté',
        save: 'Uložiť',
        addContent: 'Pridať...',
        addContentBelow: 'Pridať pod...',
        pasteContent: 'Vložiť...',
        pasteContentBelow: 'Vložiť pod...',
        move: 'Premiestniť',
        moveUp: 'Presunúť vyššie',
        moveDown: 'Presunúť nižšie',
        setting: 'Nastavenia',
        copy: 'Kopírovať',
        cut: 'Vystrihnúť',
        delete: 'Vymazať',
        snippetCategoryLabel: 'Kategória',
        snippetCategoryAll: 'Všetky',
        snippetCategorySearch: 'Vyhľadať...',
        columnResizeTitle: 'Zmeniť rozmer',
        containerSetting: 'Nastavenia',
        confirmDeleteContainerText: 'Naozaj vymazať? Zmeny budú permanentné!',
        confirmDeleteComponentText: 'Naozaj vymazať? Zmeny budú permanentné!',
    };

    const options = function($element)
    {
        return {
            rx: window.rx(),
            title: '',
            locale: locale,
            contentStyles: [
                {
                    id: 'keditor',
                    href: "{{ asset('vendor/softworx/rocXolid/plugins/keditor/css/keditor.css') }}"
                },
                {
                    id: 'keditor-components',
                    href: "{{ asset('vendor/softworx/rocXolid/plugins/keditor/css/keditor-components.css') }}"
                },
                {
                    id: 'font-awesome',
                    href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
                }
            ],
            snippetsUrl: $element.data('snippets-url'),
            bootstrap: {
                ...$.fn.keditor.constructor.DEFAULTS.bootstrap,
                deviceClass: {
                    DESKTOP: 'lg'
                },
            },
            containerForQuickAddComponent: `{!! $component->getModel()->getDocumentEditorContainerForQuickAddComponent() !!}`,
            extraTopbarItems: (function($container) {
                let extraItems = {};

                if ($container.is('[data-preview-pdf-url]')) {
                    extraItems['pdf'] = {
                        html: '<a href="javascript:void(0);" title="PDF Preview" class="keditor-ui keditor-topbar-btn"><i class="fa fa-fw fa-file-pdf-o"></i></a>',
                        click: function() {
                            const root = serialize($('<div>').html($container.keditor('getContent')), null, [], parseNodeContent);

                            elementableApi.previewComposition($element, root.children);
                        }
                    };
                }

                return extraItems;
            })($element),
            onInitIframe: function (iframe, iframeHead, iframeBody) {
                setTimeout(function() {
                    $element
                        .closest('[data-keditor]')
                        .removeClass('d-none')
                        .addClass('animated slideInDown speed-400');
                }, 500);
            },
            onContentChanged: function (event, contentArea) {
                window.isContentDirty = true;
            },
            onComponentReady: function (component) {
                // console.log('onComponentReady', component);
            },
            onContainerSnippetAdded: function (event, newContainer, selectedSnippet, contentArea) {
                console.log('onContainerSnippetAdded');
            },
            onBeforeContainerDeleted: function (event, component, contentArea) {
                if ($(component[0].innerHTML).find('[data-element-type]').first().data('elementId')) {
                    return elementableApi.deleteComponent($element, component);
                }
            },
            onContainerDeleted: function (event, selectedContainer, contentArea) {
                window.isContentDirty = false;
            },
            onComponentSnippetAdded: function (event, newComponent, selectedSnippet, contentArea) {
                console.log('onComponentSnippetAdded');
            },
            onBeforeComponentDeleted: function (event, component, contentArea) {
                if ($(component[0].innerHTML).find('[data-element-type]').first().data('elementId')) {
                    return elementableApi.deleteComponent($element, component);
                }
            },
            onComponentDeleted: function (event, selectedContainer, contentArea) {
                window.isContentDirty = false;
            },
            onBeforeDynamicContentLoad: function (dynamicElement, component, contentArea) {
                console.log('onBeforeDynamicContentLoad');
            },
            onDynamicContentLoaded: function (dynamicElement, jqXHR, contentArea) {
                console.log('onDynamicContentLoaded');
            },
            onSave: function (content) {
                const root = serialize($('<div>').html(content), null, [], parseNodeContent);

                console.log('Elements tree', root);

                window.isContentDirty = false;

                elementableApi.storeComposition($element, root.children);
            },
        }
    }

    $('.content-composition').each(function() {
        $(this).keditor(options($(this)));
    })
});
</script>
@endpush