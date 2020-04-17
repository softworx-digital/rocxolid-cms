<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div data-keditor="html">
        <div
            class="content-composition"
            data-snippets-url="{{ $component->getController()->getRoute('pageElementSnippets', $component->getModel()) }}"
            data-preview-pdf-url="{{ $component->getController()->getRoute('previewPdf', $component->getModel()) }}">
        </div>
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>

@push('script')
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/softworx/rocXolid/plugins/keditor/js/keditor.js') }}"></script>
<script src="{{ asset('vendor/softworx/rocXolid/plugins/keditor/js/keditor-components.js') }}"></script>
<script type="text/javascript" data-keditor="script">
$(document).ready(function($)
{
    let $element = $('.content-composition');

    $element.keditor({
        rx: window.rx(),
        title: '',
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
                id: 'bootstrap',
                href: "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css"
            },
            {
                id: 'font-awesome',
                href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
            },/*
            {
                id: 'summernote',
                href: "https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css"
            }*/
        ],
        snippetsUrl: $element.data('snippets-url'),
        extraTopbarItems: {
            pdf: {
                html: '<a href="javascript:void(0);" title="PDF Preview" class="keditor-ui keditor-topbar-btn"><i class="fa fa-fw fa-file-pdf-o"></i></a>',
                click: function() {
                    window.rxUtility().ajaxCall({
                        rx: window.rx(),
                        element: $element,
                        type: 'post',
                        url: $element.data('preview-pdf-url'),
                        data: {
                            content: $element.keditor('getContent')
                        }
                    });
                }
            }
        },
        onContainerSnippetAdded: function (event, newContainer, selectedSnippet, contentArea) {
            console.log('onContainerSnippetAdded');
        },
        onBeforeContainerDeleted: function (event, selectedContainer, contentArea) {
            console.log('onBeforeContainerDeleted');
        },
        onComponentSnippetAdded: function (event, newComponent, selectedSnippet, contentArea) {
            console.log('onComponentSnippetAdded');
        },
        onBeforeComponentDeleted: function (event, selectedComponent, contentArea) {
            console.log('onBeforeComponentDeleted');
        },
        onBeforeDynamicContentLoad: function (dynamicElement, component, contentArea) {
            console.log('onBeforeDynamicContentLoad');
        },
        onDynamicContentLoaded: function (dynamicElement, jqXHR, contentArea) {
            console.log('onDynamicContentLoaded');
        },
    });
});
</script>
@endpush