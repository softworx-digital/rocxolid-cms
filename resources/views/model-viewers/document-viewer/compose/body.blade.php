<div class="panel-heading">
    <h3 class="panel-title">{{ $component->translate('text.body') }}</h3>
</div>
<div class="panel-body padding-0">
    <div class="d-none" data-keditor="html">
        <div
            class="content-composition"
            data-snippets-url="{{ $component->getModel()->getControllerRoute('elementSnippets') }}"
            data-update-url="{{ $component->getModel()->getControllerRoute('storeComposition') }}"
            data-preview-pdf-url="{{ $component->getModel()->getControllerRoute('previewPdf') }}"
            data-element-detach-url="{{ $component->getModel()->getControllerRoute('detachElement') }}"
            data-element-destroy-url="{{ $component->getModel()->getControllerRoute('destroyElement') }}">
            {!! $component->render('include.elements') !!}
        </div>
    </div>
</div>