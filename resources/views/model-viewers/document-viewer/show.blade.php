<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="d-none" data-keditor="html">
        <div
            class="content-composition"
            data-snippets-url="{{ $component->getController()->getRoute('elementSnippets', $component->getModel()) }}"
            data-update-url="{{ $component->getController()->getRoute('storeComposition', $component->getModel()) }}"
            data-preview-pdf-url="{{ $component->getController()->getRoute('previewPdf', $component->getModel()) }}"
            data-element-detach-url="{{ $component->getController()->getRoute('detachElement', $component->getModel()) }}"
            data-element-destroy-url="{{ $component->getController()->getRoute('destroyElement', $component->getModel()) }}">
        @foreach ($component->getModel()->elements() as $element)
            {!! $element->getModelViewerComponent()->render($element->getPivotData()->get('template')) !!}
        @endforeach
        </div>
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>

@push('script')
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="{{ asset('vendor/softworx/rocXolid/plugins/keditor/js/keditor.js') }}"></script>
<script src="{{ asset('vendor/softworx/rocXolid/plugins/keditor/js/keditor-components.js') }}"></script>

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
                gridLayout: {},
                content: [],
            },
            children: []
        };

        for (let i in $node.data()) {
            // put only defined data, or all if not defined
            if (!onlyData.length || onlyData.includes(i)) {
                element[i] = $node.data(i);
            }
        }

        if ($node.find('.content-container .editable')) {
            element.elementData.content = $.trim($node.html());
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
            element = onNodeCreated($node, element, onlyData);
        }

        return element;
    };

    const parseNodeContent = function($node, element, onlyData)
    {
        if (typeof $node.attr('class') == 'string') {
            let colAttrs = $node.attr('class').split(' ').forEach(function (className) {
                if (col = className.match(/\bcol-(\w+)-(\d+)/)) {
                    element.elementData.gridLayout[col[1]] = col[2];
                }
            });
        }

        return element;
    };

    const elementableApi = {
        previewComposition: function(composition) {
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
        storeComposition: function(composition) {
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
        deleteComponent: function(component) {
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
        addContent: 'Pridať obsah',
        addContentBelow: 'Pridať obsah pod container',
        pasteContent: 'Vložiť obsah',
        pasteContentBelow: 'Vložiť obsah pod container',
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
        containerSetting: 'Nastavenia containera',
        confirmDeleteContainerText: 'Naozaj vymazať tento container? Zmeny budú permanentné!',
        confirmDeleteComponentText: 'Naozaj vymazať tento komponent? Zmeny budú permanentné!',
    };

    let $element = $('.content-composition');

    $element.keditor({
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
        containerForQuickAddComponent: `{!! $component->getModel()->getDocumentEditorContainerForQuickAddComponent() !!}`,
        extraTopbarItems: {
            pdf: {
                html: '<a href="javascript:void(0);" title="PDF Preview" class="keditor-ui keditor-topbar-btn"><i class="fa fa-fw fa-file-pdf-o"></i></a>',
                click: function() {
                    const root = serialize($('<div>').html($element.keditor('getContent')), null, [], parseNodeContent);

                    elementableApi.previewComposition(root.children);
                }
            }
        },
        onInitIframe: function (iframe, iframeHead, iframeBody) {
            setTimeout(function() {
                $element
                    .closest('[data-keditor]')
                    .removeClass('d-none')
                    .addClass('animated fadeIn faster');
            }, 500);
        },
        onContentChanged: function (event, contentArea) {
            window.isContentDirty = true;
        },
        onComponentReady: function (component) {
            console.log('onComponentReady', component);
        },
        onContainerSnippetAdded: function (event, newContainer, selectedSnippet, contentArea) {
            console.log('onContainerSnippetAdded');
        },
        onBeforeContainerDeleted: function (event, component, contentArea) {
            if ($(component[0].innerHTML).find('[data-element-type]').first().data('elementId')) {
                return elementableApi.deleteComponent(component);
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
                return elementableApi.deleteComponent(component);
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

            elementableApi.storeComposition(root.children);
        },
    });
});
</script>
@endpush